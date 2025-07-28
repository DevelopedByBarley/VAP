<?php

class XLSX
{
    private $pdo;
    private $alert;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getConnect();
        $this->alert = new Alert();
    }


    public function write($data, $headers = [
        "id",
        "regisztráció ID",
        "név",
        "email",
        "cím",
        "mobil",
        "foglalkozás",
        "iskola",
        "további nyelvek",
        "dátumok",
        "nyelvek"
    ])
    {
        $uri = $_SERVER["REQUEST_URI"];

        if (empty($data) || !is_array($data)) {
            $this->alert->set("Még nincs egy elfogadott regisztráció sem, ezért az exportálás nem lehetséges", "Még nincs egy elfogadott regisztráció sem, ezért az exportálás nem lehetséges", "Még nincs egy elfogadott regisztráció sem, ezért az exportálás nem lehetséges", "danger", $uri);
        }

        $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $excel->getActiveSheet();


        // Először beírjuk a fejléceket
        $columnIndex = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($columnIndex, 1, $header);
            $columnIndex++;
        }

        // Ezután beírjuk az adatokat
        $rowIndex = 2; // A második sorral kezdünk
        foreach ($data as $rowData) {
            $columnIndex = 1;
            foreach ($rowData as $key => $value) {
                if ($key === 'dates') {
                    $formattedDates = implode(', ', explode(' ', $value));
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $formattedDates);
                } elseif ($key === 'langs') {
                    $formattedLangs = [];
                    foreach ($value as $langData) {
                        $formattedLangs[] = $langData['lang'] . ': ' . $langData['level'];
                    }
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, implode(', ', $formattedLangs));
                } else {
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                }
                $columnIndex++;
            }
            $rowIndex++;
        }

        // Exportálás
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="export_data_' . time() . '.xlsx"');
        header('Cache-Control: max-age=0');

        $xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
        $xlsxWriter->save('php://output');
        exit;
    }

    public function getAllReg() {
        $stmt = $this->pdo->prepare("SELECT id, name, email, address, mobile, profession, schoolName, otherLanguages FROM `users`");
        $stmt->execute();
        $regData = $stmt->fetchAll(PDO::FETCH_ASSOC);



        foreach ($regData as $index => $reg) {
            $subData[$index]["dates"] = self::getDatesOfSub($reg);
            $subData[$index]["tasks"] = self::getTaskOfSub($reg);
            $subData[$index]["langs"] = self::getLangsOfSub($reg);
        }

        return $regData;
    }

    public function getAcceptedSubs($id)
    {

        $stmt = $this->pdo->prepare("SELECT id, registrationId, name, email, address, mobile, profession, schoolName, otherLanguages FROM `registrations` WHERE eventRefId = :id AND isAccepted = 1");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $subData = $stmt->fetchAll(PDO::FETCH_ASSOC);



        foreach ($subData as $index => $sub) {
            $subData[$index]["dates"] = self::getDatesOfSub($sub);
            $subData[$index]["tasks"] = self::getTaskOfSub($sub);
            $subData[$index]["langs"] = self::getLangsOfSub($sub);
        }



        return $subData;
    }


    private function getDatesOfSub($sub)
    {

        $stmt = $this->pdo->prepare("SELECT *  FROM `registration_dates` WHERE registerRefId = :id");
        $stmt->bindParam(":id", $sub["id"], PDO::PARAM_INT);
        $stmt->execute();
        $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);



        return implode(" ", array_column($dates, "date"));
    }

    private function getTaskOfSub($sub)
    {

        $stmt = $this->pdo->prepare("SELECT task FROM `registration_tasks` WHERE registerRefId = :id");
        $stmt->bindParam(":id", $sub["id"], PDO::PARAM_INT);
        $stmt->execute();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);




        foreach ($tasks as $index => $taskData) {
            $tasks[$index] = TASK_AREAS["areas"][(int)$taskData["task"]]["Hu"];
        }

        return implode(', ', $tasks);
    }


    private function getLangsOfSub($sub)
    {

        $stmt = $this->pdo->prepare("SELECT lang, level FROM `registration_languages` WHERE registerRefId = :id");
        $stmt->bindParam(":id", $sub["id"], PDO::PARAM_INT);
        $stmt->execute();
        $langs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $ret = [];


        foreach ($langs as $index => $lang) {
            $ret[$index] = [
                "lang" => Languages[$lang["lang"]]["Hu"],
                "level" => Levels[$lang["level"]]["Hu"],
            ];
        };


        return $ret;
    }
}
