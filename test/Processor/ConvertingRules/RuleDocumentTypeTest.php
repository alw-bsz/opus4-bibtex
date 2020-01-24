<?php
/**
 * This file is part of OPUS. The software OPUS has been originally developed
 * at the University of Stuttgart with funding from the German Research Net,
 * the Federal Department of Higher Education and Research and the Ministry
 * of Science, Research and the Arts of the State of Baden-Wuerttemberg.
 *
 * OPUS 4 is a complete rewrite of the original OPUS software and was developed
 * by the Stuttgart University Library, the Library Service Center
 * Baden-Wuerttemberg, the Cooperative Library Network Berlin-Brandenburg,
 * the Saarland University and State Library, the Saxon State Library -
 * Dresden State and University Library, the Bielefeld University Library and
 * the University Library of Hamburg University of Technology with funding from
 * the German Research Foundation and the European Regional Development Fund.
 *
 * LICENCE
 * OPUS is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the Licence, or any later version.
 * OPUS is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details. You should have received a copy of the GNU General Public License
 * along with OPUS; if not, write to the Free Software Foundation, Inc., 51
 * Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * @category    Tests
 * @package     OpusTest\Processor\ConvertingRules
 * @author      Maximilian Salomon <salomon@zib.de>
 * @copyright   Copyright (c) 2020, OPUS 4 development team
 * @license     http://www.gnu.org/licenses/gpl.html General Public License
 */

namespace OpusTest\Processor\ConvertingRules;

use Opus\Processor;

class RuleDocumentTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testProcessPtypeConference()
    {
        $rule = new Processor\ConvertingRules\RuleDocumentType();
        $bibtexBlock = [
            'ptype' => 'conference'
        ];

        $return = $rule->process(
            'Ptype',
            'conference',
            $bibtexBlock
        );

        $expected = [
            true,
            'Type',
            'conferenceobject'
        ];

        $this->assertEquals($expected, $return);
    }

    public function testProcessPtypeJournal()
    {
        $rule = new Processor\ConvertingRules\RuleDocumentType();
        $bibtexBlock = [
            'ptype' => 'journal'
        ];

        $return = $rule->process(
            'Ptype',
            'journal',
            $bibtexBlock
        );

        $expected = [
            true,
            'Type',
            'article'
        ];

        $this->assertEquals($expected, $return);
    }

    public function testProcessReftypeArticle()
    {
        $rule = new Processor\ConvertingRules\RuleDocumentType();
        $bibtexBlock = [
            'type' => 'article'
        ];

        $return = $rule->process(
            'type',
            'article',
            $bibtexBlock
        );

        $expected = [
            true,
            'Type',
            'article'
        ];

        $this->assertEquals($expected, $return);
    }

    public function testProcessTwoInfos()
    {
        $rule = new Processor\ConvertingRules\RuleDocumentType();
        $bibtexBlock = [
            'ptype' => 'conference',
            'type' => 'article'
        ];

        $return = $rule->process(
            'type',
            'article',
            $bibtexBlock
        );

        $expected = [
            true,
            'Type',
            'conferenceobject'
        ];

        $this->assertEquals($expected, $return);
    }
}
