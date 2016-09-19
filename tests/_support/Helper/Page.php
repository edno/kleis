<?php

namespace Helper;

class Page extends \Codeception\Module
{
    public function findElements($target)
    {
        return $this->getModule('PhpBrowser')->_findElements($target);
    }

    public function htmlTableToArray($target)
    {
        $tables = $this->findElements($target);
        if (sizeof($tables) == 1) {
            /* Retrieve table headers */
            $cells = $tables->getNode(0)->getElementsByTagName('th');
            foreach($cells as $key => $cell) {
                // dirty hack for removing non-printable characters
                $text = preg_replace('/^[^A-z0-9].*[^A-z0-9]$/', '', $cell->nodeValue);
                if (!empty($text)) {
                    $headers[$key] = $this->cleanString($text);
                }
            }
            /* Retrieve table data rows */
            $table = [];
            $rows = $tables->getNode(0)->getElementsByTagName('tr');
            foreach($rows as $row) {
                /* Retrieve rows cells */
                $data = [];
                $cells = $row->getElementsByTagName('td');
                foreach ($cells as $key => $cell) {
                    /* select cell with a valid column (with header) */
                    if (array_key_exists($key, $headers)) {
                        $text = trim($cell->nodeValue);
                        if (empty($text)) {
                            // if cell text is empty then get it from the tooltip title of the fontawesome icon
                            if (false === is_null($cell->getElementsByTagName('i')->item(0))) {
                                $text = $cell->getElementsByTagName('i')
                                            ->item(0)
                                            ->attributes
                                            ->getNamedItem('title')
                                            ->value;
                            // if cell text is empty then get it from the badge
                            } elseif (false === is_null($cell->getElementsByTagName('span')->item(0))) {
                                $text = $cell->getElementsByTagName('span')
                                            ->item(0)
                                            ->nodeValue;
                            }
                        }
                        $data = array_merge($data, [ $headers[$key] => $text ]);
                    }
                }
                $table[] = $data;
            }
            return $table;
        } else {
            throw new \Exception("No element or more than one element match to the expression '$target'");
        }
    }

    private function cleanString($string)
    {
        return mb_strtolower( html_entity_decode(
            preg_replace(
                '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i',
                '$1',
                htmlentities($string)
            ),
            ENT_QUOTES,
            'UTF-8'
        ));
    }
}
