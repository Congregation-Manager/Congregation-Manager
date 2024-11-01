<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Command;

use CongregationManager\Bundle\Core\Repository\OldCM\AppUserRepositoryInterface as OldAppUserRepositoryInterface;
use CongregationManager\Bundle\Core\Repository\OldCM\AreaRepository;
use CongregationManager\Bundle\Core\Repository\OldCM\BrotherRepositoryInterface as OldBrotherRepositoryInterface;
use CongregationManager\Bundle\Core\Repository\OldCM\CongregationRepositoryInterface as OldCongregationRepositoryInterface;
use CongregationManager\Bundle\Core\Repository\OldCM\MunicipalityRepository;
use CongregationManager\Bundle\Core\Repository\OldCM\ProvinceRepository;
use CongregationManager\Bundle\Core\Repository\OldCM\TerritoryAssignmentRepository;
use CongregationManager\Bundle\Core\Repository\OldCM\TerritoryRepository;
use CongregationManager\Bundle\User\Action\CreateAppUser;
use CongregationManager\Component\Congregation\Application\CreateBrother;
use CongregationManager\Component\Congregation\Application\CreateCongregation;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Application\CreateArea;
use CongregationManager\Component\TerritoryManager\Application\CreateMunicipality;
use CongregationManager\Component\TerritoryManager\Application\CreateProvince;
use CongregationManager\Component\TerritoryManager\Application\CreateTerritory;
use CongregationManager\Component\TerritoryManager\Application\CreateTerritoryAssignment;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;
use Webmozart\Assert\Assert;

final class ImportFromOldCMCommand extends Command
{
    use LockableTrait;

    private const string OLD_CONGREGATION_ID_ARGUMENT_CODE = 'old-congregation-id';

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private SymfonyStyle $io;

    /**
     * @var array<int,BrotherInterface>
     */
    private array $oldBrotherIds = [];

    public function __construct(
        private OldCongregationRepositoryInterface $oldCongregationRepository,
        private CreateCongregation $createCongregation,
        private EntityManagerInterface $entityManager,
        private OldBrotherRepositoryInterface $oldBrotherRepository,
        private CreateBrother $createBrother,
        private OldAppUserRepositoryInterface $oldAppUserRepository,
        private CreateAppUser $createAppUser,
        private ProvinceRepository $oldProvinceRepository,
        private CreateProvince $createProvince,
        private MunicipalityRepository $oldMunicipalityRepository,
        private CreateMunicipality $createMunicipality,
        private AreaRepository $oldAreaRepository,
        private CreateArea $createArea,
        private TerritoryRepository $oldTerritoryRepository,
        private CreateTerritory $createTerritory,
        private TerritoryAssignmentRepository $oldTerritoryAssignmentRepository,
        private CreateTerritoryAssignment $createTerritoryAssignment,
        private ?string $name = null
    ) {
        parent::__construct($name);
    }

    public function validateOldCongregationId(mixed $oldCongregationId): int
    {
        if (empty($oldCongregationId)) {
            throw new InvalidArgumentException('The old congregation id can not be empty.');
        }
        if (is_int($oldCongregationId)) {
            return $oldCongregationId;
        }
        Assert::string($oldCongregationId);

        return (int) $oldCongregationId;
    }

    #[\Override]
    protected function configure(): void
    {
        $this
            ->setHelp($this->getCommandHelp())
            ->addArgument(
                self::OLD_CONGREGATION_ID_ARGUMENT_CODE,
                InputArgument::REQUIRED,
                'The old id of the congregation to import'
            )
        ;
    }

    #[\Override]
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    #[\Override]
    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        /** @var mixed $oldCongregationIdArgument */
        $oldCongregationIdArgument = $input->getArgument(self::OLD_CONGREGATION_ID_ARGUMENT_CODE);
        if ($oldCongregationIdArgument !== null) {
            return;
        }

        $this->io->title('Import From Old Congregation Manager Command Interactive Wizard');
        $this->io->text([
            'If you prefer to not use this interactive wizard, provide the',
            'arguments required by this command as follows:',
            '',
            ' $ php bin/console ' . (string) $this->name . ' old-congregation-id',
            '',
            'Now we\'ll ask you for the value of all the missing command arguments.',
        ]);

        /** @var mixed|null $oldCongregationId */
        $oldCongregationId = $oldCongregationIdArgument;
        if ($oldCongregationId === null) {
            /** @var int $oldCongregationId */
            $oldCongregationId = $this->io->ask('Old congregation id', null, $this->validateOldCongregationId(...));
            $input->setArgument(self::OLD_CONGREGATION_ID_ARGUMENT_CODE, $oldCongregationId);
        }
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $this->io->error('The command is already running in another process.');

            return Command::FAILURE;
        }
        $stopwatch = new Stopwatch();
        $stopwatch->start('import-from-old-cm-command');

        // make sure to validate the user data is correct
        $oldCongregationId = $this->validateOldCongregationId(
            $input->getArgument(self::OLD_CONGREGATION_ID_ARGUMENT_CODE)
        );
        $oldCongregation = $this->oldCongregationRepository->findOneById($oldCongregationId);

        if (count($oldCongregation) === 0) {
            $this->io->error('No old congregation founded');

            return Command::FAILURE;
        }
        $oldCongregation = reset($oldCongregation);
        $congregation = $this->createCongregation->create($oldCongregation['name']);

        $this->importBrothersAndAppUsers($oldCongregationId, $congregation);

        $this->importAreasAndTerritories($oldCongregationId, $congregation);

        $this->entityManager->flush();

        $event = $stopwatch->stop('import-from-old-cm-command');
        $this->io->comment(
            sprintf(
                'Elapsed time: %.2f ms / Consumed memory: %.2f MB',
                $event->getDuration(),
                $event->getMemory() / (1024 ** 2)
            )
        );

        $this->release();

        return Command::SUCCESS;
    }

    private function getCommandHelp(): string
    {
        return <<<'CODE_SAMPLE'
            The <info>%command.name%</info> command imports congregation, brothers and users from an old CM congregation:

              <info>php %command.full_name%</info> <comment>old-congregation-id</comment>
            CODE_SAMPLE;
    }

    private function importBrothersAndAppUsers(int $oldCongregationId, CongregationInterface $congregation): void
    {
        foreach ($this->oldBrotherRepository->findAllByCongregation($oldCongregationId) as $oldBrother) {
            $brother = $this->createBrother->create(
                $oldBrother['name'],
                $oldBrother['surname'],
                $congregation,
                (bool) $oldBrother['male'],
                $oldBrother['middle_name'],
                $oldBrother['birth_date'] !== null ? new DateTime($oldBrother['birth_date']) : null,
                $oldBrother['baptism_date'] !== null ? new DateTime($oldBrother['baptism_date']) : null,
            );
            $this->oldBrotherIds[(int) $oldBrother['id']] = $brother;
            $oldAppUser = $this->oldAppUserRepository->findOneByBrother((int) $oldBrother['id']);
            if (count($oldAppUser) === 0) {
                continue;
            }
            $oldAppUser = reset($oldAppUser);
            $this->createAppUser->create($brother, $oldAppUser['email'], null, 'it', $oldAppUser['password']);
        }
    }

    private function importAreasAndTerritories(int $oldCongregationId, CongregationInterface $congregation): void
    {
        foreach ($this->oldProvinceRepository->findAllByCongregation($oldCongregationId) as $oldProvince) {
            $province = $this->createProvince->create(
                $congregation,
                $oldProvince['name'],
                $oldProvince['description'],
            );
            foreach ($this->oldMunicipalityRepository->findAllByCongregationAndProvince(
                $oldCongregationId,
                (int) $oldProvince['id']
            ) as $oldMunicipality) {
                $municipality = $this->createMunicipality->create(
                    $congregation,
                    $province,
                    $oldMunicipality['name'],
                    $oldMunicipality['description'],
                );
                foreach ($this->oldAreaRepository->findAllByCongregationAndMunicipality(
                    $oldCongregationId,
                    (int) $oldMunicipality['id']
                ) as $oldArea) {
                    $area = $this->createArea->create(
                        $congregation,
                        $municipality,
                        $oldArea['name'],
                        $oldArea['description'],
                    );
                    foreach ($this->oldTerritoryRepository->findAllByCongregationAndArea(
                        $oldCongregationId,
                        (int) $oldArea['id']
                    ) as $oldTerritory) {
                        $number = $oldTerritory['name'];
                        if (!is_numeric($number)) {
                            continue;
                        }
                        $territory = $this->createTerritory->create(
                            $congregation,
                            $area,
                            (int) $number,
                            $oldTerritory['description'],
                        );
                        foreach ($this->oldTerritoryAssignmentRepository->findAllByTerritoryId(
                            (int) $oldTerritory['id']
                        ) as $oldTerritoryAssignment) {
                            $brother = null;
                            if ($oldTerritoryAssignment['brother_id'] !== null) {
                                if (!array_key_exists(
                                    (int) $oldTerritoryAssignment['brother_id'],
                                    $this->oldBrotherIds
                                )) {
                                    throw new RuntimeException(sprintf(
                                        'Unable to create the territory assignment for brother "%s" and territory "%s", brother not found.',
                                        $oldTerritoryAssignment['brother_id'],
                                        $oldTerritory['id']
                                    ));
                                }
                                $brother = $this->oldBrotherIds[(int) $oldTerritoryAssignment['brother_id']];
                            }
                            $this->createTerritoryAssignment->create(
                                $territory,
                                new DateTime($oldTerritoryAssignment['assignment_date']),
                                $brother,
                                $oldTerritoryAssignment['revocation_date'] !== null ? new DateTime(
                                    $oldTerritoryAssignment['revocation_date']
                                ) : null
                            );
                        }
                    }
                }
            }
        }
    }
}
