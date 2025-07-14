<?php
/**
 * mds Agenturgruppe GmbH
 *
 * This source file is available under the terms of the 3-Clause BSD License
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) mds. Agenturgruppe GmbH (https://www.mds.eu)
 * @license    3-Clause BSD License (BSD-3-Clause)
 */

declare(strict_types=1);

use Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector;
use Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\Config\RectorConfig;
use Rector\Php55\Rector\Class_\ClassConstantToSelfClassRector;
use Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\Symfony\CodeQuality\Rector\ClassMethod\ActionSuffixRemoverRector;
use Utils\Rector\RemoveCommentFromConstructorPromotionRector;

$CWD = getcwd();

$bootstrapFiles = [];

$pimcoreConstantStub = $CWD . '/vendor/pimcore/pimcore/stubs/dynamic-constants.php';
if (file_exists($pimcoreConstantStub)) {
    $bootstrapFiles[] = $pimcoreConstantStub;
}

return RectorConfig::configure()
                   ->withPaths(
                       [
                           $CWD . '/bundles',
                           $CWD . '/src',
                       ]
                   )
                   ->withSkip(
                       [
                           $CWD . '/*/node_modules/*',
                           $CWD . '/*/DependencyInjection/*',
                           ActionSuffixRemoverRector::class,
                           ClassConstantToSelfClassRector::class,
                           DisallowedEmptyRuleFixerRector::class,
                           EncapsedStringsToSprintfRector::class,
                           ExplicitBoolCompareRector::class,
                           IssetOnPropertyObjectToPropertyExistsRector::class,
                           PrivatizeLocalGetterToPropertyRector::class,
                           SwitchNegatedTernaryRector::class,
                           ThrowWithPreviousExceptionRector::class,
                       ]
                   )
                   ->withRules(
                       [
                           RemoveCommentFromConstructorPromotionRector::class
                       ]
                   )
                   ->withBootstrapFiles($bootstrapFiles)
                   ->withPhpSets()
                   ->withComposerBased(twig: true, doctrine: true, phpunit: false, symfony: true)
                   ->withPHPStanConfigs(
                       [
                           $CWD . '/phpstan.neon',
                       ]
                   )
                   ->withAttributesSets(symfony: true)
                   ->withImportNames(importShortClasses: false, removeUnusedImports: true)
                   ->withSymfonyContainerXml($CWD . '/var/cache/dev/App_KernelDevDebugContainer.xml')
                   ->withDeadCodeLevel(18)
                   ->withPreparedSets(
                       deadCode           : false,
                       codeQuality        : true,
                       codingStyle        : true,
                       typeDeclarations   : true,
                       privatization      : true,
                       naming             : false,
                       instanceOf         : true,
                       earlyReturn        : true,
                       strictBooleans     : false,
                       carbon             : false,
                       rectorPreset       : false,
                       phpunitCodeQuality : false,
                       doctrineCodeQuality: false,
                       symfonyCodeQuality : true,
                       symfonyConfigs     : true
                   );
