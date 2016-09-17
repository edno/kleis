<?php

namespace Helper;

class Page extends \Codeception\Module
{
    public function findElements($target)
    {
        return $this->getModule('Laravel5')->_findElements($target);
    }

    public function htmlTableToArray($target)
    {
        $tables = $this->findElements($target);
        if (sizeof($tables) == 1) {
            /* Retrieve table headers */
            $rows = $tables->getNode(0)->getElementsByTagName('th');
            foreach($rows as $key => $row) {
                // dirty hack for removing non-printable characters
                $text = preg_replace('/^[^A-z0-9].*[^A-z0-9]$/', '', $row->nodeValue);
                if (!empty($text)) {
                    $headers[$key] = mb_strtolower($text);
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
                            $text = $cell->getElementsByTagName('i')->item(0)->attributes->getNamedItem('title')->value;
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
}
