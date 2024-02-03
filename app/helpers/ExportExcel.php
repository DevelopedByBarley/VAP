<?php


class XLSX
{
    public function write($data)
    {
        // Excel file name for download 
        $fileName = "codexworld_export_data-" . date('Ymd') . ".xlsx";

        // Headers for download 
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-Type: application/vnd.ms-excel");

        $flag = false;
        foreach ($data as $row) {
            if (!$flag) {
                // display column names as first row 
                echo implode("\t", array_keys($row)) . "\n";
                $flag = true;
            }
            // filter data 
            $filteredRow = array_map(array($this, 'filterData'), $row);
            echo implode("\t", $filteredRow) . "\n";
        }

        exit;
    }

    public function filterData($str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        return $str;
    }
}
