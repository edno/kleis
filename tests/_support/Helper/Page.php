<?php

namespace Helper;

class Page extends \Codeception\Module
{
    public function findElements($target)
    {
        return $this->getModule('WebDriver')->_findElements($target);
    }

    public function convertHtmlTableToArray($target)
    {
        $tables = $this->findElements($target);
        if (sizeof($tables) == 1) {
            /* Retrieve table headers */
            $cells = $tables[0]->findElements(\WebDriverBy::xpath('//th'));
            foreach($cells as $key => $cell) {
                // dirty hack for removing non-printable characters
                $text = trim(preg_replace('/^[^A-z0-9].*[^A-z0-9]$/', '', $cell->getText()));
                if (!empty($text)) {
                    $headers[$key] = $this->cleanString($text);
                }
            }

            /* Retrieve table data rows */
            $table = [];
            $rows = $tables[0]->findElements(\WebDriverBy::tagName('tr'));
            foreach($rows as $row) {
                /* Retrieve rows cells */
                $data = [];
                $cells = $row->findElements(\WebDriverBy::tagName('td'));
                foreach ($cells as $key => $cell) {
                    /* select cell with a valid column (with header) */
                    if (array_key_exists($key, $headers)) {
                        $text = trim($cell->getText());
                        if ($text == '') {
                            // if cell text is empty then get it from the tooltip title of the fontawesome icon
                            if (false === is_null($cell->findElement(\WebDriverBy::tagName('i')))) {
                                $text = $cell->findElement(\WebDriverBy::tagName('i'))
                                            ->getAttribute('data-original-title');
                            }
                        }
                        $data = array_merge($data, [ $headers[$key] => $text ]);
                    }
                }
                if (false === empty($data)) {
                    $table[] = $data;
                }
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
