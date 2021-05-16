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
 * @copyright   Copyright (c) 2021, OPUS 4 development team
 * @license     http://www.gnu.org/licenses/gpl.html General Public License
 *
 * @category    BibTeX
 * @package     Opus\Bibtex\Import\Rules
 * @author      Sascha Szott <opus-repository@saschaszott.de>
 */

namespace Opus\Bibtex\Import\Rules;

use function array_key_exists;
use function array_push;
use function count;
use function is_array;

/**
 * Eine Regel, die verwendet werden kann, um ein mehrwertiges Metadatenfeld (Feldwert ist hierbei ein Array) zu füllen.
 */
abstract class ArrayRule extends SimpleRule
{
    /**
     * Anwendung der Regel auf den übergebenen BibTeX-Record.
     *
     * @param array $bibtexRecord BibTeX-Record (Array von BibTeX-Feldern)
     * @param array $documentMetadata OPUS-Metadatensatz (Array von Metadatenfeldern)
     * @return bool liefert true, wenn die Regel erfolgreich angewendet werden konnte
     */
    public function apply($bibtexRecord, &$documentMetadata)
    {
        $result = false;
        if (array_key_exists($this->bibtexField, $bibtexRecord)) {
            $fieldValue = $this->getValue($bibtexRecord[$this->bibtexField]);
            if (count($fieldValue) > 0) {
                $result = true;
                if (array_key_exists(0, $fieldValue) && is_array($fieldValue[0])) {
                    // $fieldValue ist ein mehrdimensionales Array
                    if (! array_key_exists($this->opusField, $documentMetadata)) {
                        $documentMetadata[$this->opusField] = [];
                    }
                    array_push($documentMetadata[$this->opusField], ...$fieldValue);
                } else {
                    $documentMetadata[$this->opusField][] = $fieldValue;
                }
            }
        }
        return $result;
    }
}
