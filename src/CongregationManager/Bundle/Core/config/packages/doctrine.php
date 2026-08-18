<?php

declare(strict_types=1);

use CongregationManager\Bundle\Core\Entity\AdminUser;
use CongregationManager\Bundle\Core\Entity\AppUser;
use CongregationManager\Component\Congregation\Domain\BrotherInterface as DomainBrotherInterface;
use CongregationManager\Component\Congregation\Domain\CongregationInterface as DomainCongregationInterface;
use CongregationManager\Component\Core\Domain\AdminUserInterface as CoreAdminUserInterface;
use CongregationManager\Component\Core\Domain\AppUserInterface as CoreAppUserInterface;
use CongregationManager\Component\Core\Domain\AppUserInvitation as DomainAppUserInvitation;
use CongregationManager\Component\Core\Domain\AppUserInvitationInterface as CoreAppUserInvitationInterface;
use CongregationManager\Component\Core\Domain\Area as DomainArea;
use CongregationManager\Component\Core\Domain\AreaInterface as CoreAreaInterface;
use CongregationManager\Component\Core\Domain\Brother as DomainBrother;
use CongregationManager\Component\Core\Domain\BrotherInterface as CoreBrotherInterface;
use CongregationManager\Component\Core\Domain\Congregation as DomainCongregation;
use CongregationManager\Component\Core\Domain\CongregationInterface as CoreCongregationInterface;
use CongregationManager\Component\Core\Domain\Municipality as DomainMunicipality;
use CongregationManager\Component\Core\Domain\MunicipalityInterface as CoreMunicipalityInterface;
use CongregationManager\Component\Core\Domain\Province as DomainProvince;
use CongregationManager\Component\Core\Domain\ProvinceInterface as CoreProvinceInterface;
use CongregationManager\Component\Core\Domain\Territory as DomainTerritory;
use CongregationManager\Component\Core\Domain\TerritoryAssignment as DomainTerritoryAssignment;
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
        ->resolveTargetEntity(DomainAreaInterface::class, DomainArea::class)
        ->resolveTargetEntity(CoreAreaInterface::class, DomainArea::class)
        ->resolveTargetEntity(DomainMunicipalityInterface::class, DomainMunicipality::class)
        ->resolveTargetEntity(CoreMunicipalityInterface::class, DomainMunicipality::class)
        ->resolveTargetEntity(DomainProvinceInterface::class, DomainProvince::class)
        ->resolveTargetEntity(CoreProvinceInterface::class, DomainProvince::class)
        ->resolveTargetEntity(DomainTerritoryInterface::class, DomainTerritory::class)
        ->resolveTargetEntity(CoreTerritoryInterface::class, DomainTerritory::class)
        ->resolveTargetEntity(DomainTerritoryAssignmentInterface::class, DomainTerritoryAssignment::class)
        ->resolveTargetEntity(CoreTerritoryAssignmentInterface::class, DomainTerritoryAssignment::class)
        ->resolveTargetEntity(DomainBrotherInterface::class, DomainBrother::class)
        ->resolveTargetEntity(CoreBrotherInterface::class, DomainBrother::class)
        ->resolveTargetEntity(DomainCongregationInterface::class, DomainCongregation::class)
        ->resolveTargetEntity(CoreCongregationInterface::class, DomainCongregation::class)
        ->resolveTargetEntity(CoreAppUserInvitationInterface::class, DomainAppUserInvitation::class)
    ;
    $emDefault = $doctrine->orm()
        ->entityManager('default');

    $emDefault->autoMapping(true);
    /** @var MappingConfig $modelMapping */
    $modelMapping = $emDefault->mapping('CongregationManagerCoreBundleModel');
    $modelMapping
        ->isBundle(false)
        ->type('xml')
        ->dir('%kernel.project_dir%/src/CongregationManager/Bundle/Core/config/doctrine/model')
        ->prefix('CongregationManager\Component\Core\Domain')
    ;
    /** @var MappingConfig $mapping */
    $mapping = $emDefault->mapping('CongregationManagerCoreBundle');
    $mapping
        ->isBundle(true)
        ->type('xml')
        ->dir('config/doctrine/entity')
        ->prefix('CongregationManager\Bundle\Core\Entity')
    ;
};
