<?php

class Normalization
{
    private array $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }


    /**
     * @param string $path
     * @return array
     */
    public static function setData(string $path): array
    {
        $file = fopen($path, "r");
        $size = filesize($path);
        $content = fread($file, $size);

        return explode(",", $content);
    }


    /**
     * @param array $data
     * @return array
     */
    public function cleanData(array $data): array
    {
        $cleanedData = [];
        $data = str_replace(['(', ')', '+', '-', ' '], '', $data);

        foreach ($data as $row) {
            $columns = explode(",", $row);

            if (isset($columns[3]) && preg_match('/^0\d{9}$/', $columns[3])) {
                $columns[3] = '38' . substr($columns[3], 1);
            }

            $cleanedData[] = implode(",", $columns);
        }

        return $cleanedData;
    }

    public function formatData(array $data): array
    {
        $lowerCaseData = strtolower($data);

        $formatedData = str_replace(['(', ')', '+', '-', ' '], '', $lowerCaseData);

        return $formatedData;
    }







}