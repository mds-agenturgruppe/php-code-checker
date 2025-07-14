<?php
/**
 * mds Agenturgruppe GmbH
 *
 * This source file is licensed under GNU General Public License version 3 (GPLv3).
 *
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) mds. Agenturgruppe GmbH (https://www.mds.eu)
 */
declare(strict_types=1);

namespace Utils\Rector;

use PhpParser\Node;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Class RemoveCommentFromConstructorPromotionRector
 *
 * @package Utils\Rector
 */
final class RemoveCommentFromConstructorPromotionRector extends AbstractRector
{
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    /**
     * @param \PhpParser\Node\Stmt\Class_ $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$node instanceof ClassMethod) {
            return null;
        }

        if (!$this->isName($node, '__construct')) {
            return null;
        }

        foreach ($node->params as $param) {
            if ($param instanceof Param) {
                $comments = $param->getComments();
                if ($comments !== []) {
                    $param->setAttribute('comments', []);
                }
            }
        }

        return $node;
    }

    /**
     * @return RuleDefinition
     * @throws \Symplify\RuleDocGenerator\Exception\PoorDocumentationException
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Remove comments from constructor arguments',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct(
        string $name, // This is a comment
        int $age /* This is a multi-line comment
                     that spans multiple lines */
    ) {
        $this->name = $name;
        $this->age = $age;
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age = $age;
    }
}
CODE_SAMPLE
                ),
            ]
        );
    }
}
