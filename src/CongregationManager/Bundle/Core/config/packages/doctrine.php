<?php

declare(strict_types=1);

use CongregationManager\Bundle\Core\Entity\AdminUser;
use CongregationManager\Bundle\Core\Entity\AppUser;
use CongregationManager\Bundle\Core\Entity\AppUserInvitation;
use CongregationManager\Bundle\Core\Entity\Area;
use CongregationManager\Bundle\Core\Entity\Brother;
use CongregationManager\Bundle\Core\Entity\Congregation;
use CongregationManager\Bundle\Core\Entity\Municipality;
use CongregationManager\Bundle\Core\Entity\Province;
use CongregationManager\Bundle\Core\Entity\Territory;
use CongregationManager\Bundle\Core\Entity\TerritoryAssignment;
use CongregationManager\Component\Congregation\Domain\BrotherInterface as DomainBrotherInterface;
use CongregationManager\Component\Congregation\Domain\CongregationInterface as DomainCongregationInterface;
use CongregationManager\Component\Core\Domain\AdminUserInterface as CoreAdminUserInterface;
use CongregationManager\Component\Core\Domain\AppUserInterface as CoreAppUserInterface;
use CongregationManager\Component\Core\Domain\AppUserInvitationInterface as CoreAppUserInvitationInterface;
use CongregationManager\Component\Core\Domain\AreaInterface as CoreAreaInterface;
use CongregationManager\Component\Core\Domain\BrotherInterface as CoreBrotherInterface;
use CongregationManager\Component\Core\Domain\CongregationInterface as CoreCongregationInterface;
use CongregationManager\Component\Core\Domain\MunicipalityInterface as CoreMunicipalityInterface;
use CongregationManager\Component\Core\Domain\ProvinceInterface as CoreProvinceInterface;
use CongregationManager\Component\Core\Domain\TerritoryAssignmentInterface as CoreTerritoryAssignmentInterface;
use CongregationManager\Component\Core\Domain\TerritoryInterface as CoreTerritoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface as DomainAreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface as DomainMunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface as DomainProvinceInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface as DomainTerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface as DomainTerritoryInterface;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig\MappingConfig;
use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $doctrine): void {
    $doctrine->orm()
        ->resolveTargetEntity(CoreAppUserInterface::class, AppUser::class)
        ->resolveTargetEntity(CoreAdminUserInterface::class, AdminUser::class)
        ->resolveTargetEntity(DomainAreaInterface::class, Area::class)
        ->resolveTargetEntity(CoreAreaInterface::class, Area::class)
        ->resolveTargetEntity(DomainMunicipalityInterface::class, Municipality::class)
        ->resolveTargetEntity(CoreMunicipalityInterface::class, Municipality::class)
        ->resolveTargetEntity(DomainProvinceInterface::class, Province::class)
        ->resolveTargetEntity(CoreProvinceInterface::class, Province::class)
        ->resolveTargetEntity(DomainTerritoryInterface::class, Territory::class)
        ->resolveTargetEntity(CoreTerritoryInterface::class, Territory::class)
        ->resolveTargetEntity(DomainTerritoryAssignmentInterface::class, TerritoryAssignment::class)
        ->resolveTargetEntity(CoreTerritoryAssignmentInterface::class, TerritoryAssignment::class)
        ->resolveTargetEntity(DomainBrotherInterface::class, Brother::class)
        ->resolveTargetEntity(CoreBrotherInterface::class, Brother::class)
        ->resolveTargetEntity(DomainCongregationInterface::class, Congregation::class)
        ->resolveTargetEntity(CoreCongregationInterface::class, Congregation::class)
        ->resolveTargetEntity(CoreAppUserInvitationInterface::class, AppUserInvitation::class)
    ;
    $emDefault = $doctrine->orm()
        ->entityManager('default');

    $emDefault->autoMapping(true);
    /** @var MappingConfig $mapping */
    $mapping = $emDefault->mapping('CongregationManagerCoreBundle');
    $mapping
        ->isBundle(true)
        ->type('xml')
        ->dir('config/doctrine')
        ->prefix('CongregationManager\Bundle\Core\Entity')
    ;
};
