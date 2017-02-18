<?php

$header = <<<EOF
(c) Antal Áron <antalaron@antalaron.hu>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

return Symfony\CS\Config\Config::create()
    ->setUsingLinter(false)
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers([
        'header_comment',
        'multiline_spaces_before_semicolon',
        'newline_after_open_tag',
        'ordered_use',
        'short_array_syntax',
        'strict',
        'strict_param',
    ])
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()
            ->in(__DIR__)
            ->exclude([
                'vendor',
                'bin/.ci',
                'bin/.travis',
                'doc',
                'var',
            ])
    )
;
