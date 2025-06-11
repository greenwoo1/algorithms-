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

    /**
     * @return array
     */
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
        $rows = [];
        if (($handle = fopen($path, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",", '"', "\\")) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
        }

        return $rows;
    }


    /**
     * @param array|string $data
     * @return array|string
     */
    public function cleanData(array|string $data): array|string
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->cleanData($value);
            }
            return $data;
        }

        $data = trim($data);
        $data = preg_replace('/\s+/', ' ', $data);
        $data = mb_strtolower($data, 'UTF-8');

        $digits = preg_replace('/\D+/', '', $data);

        if (preg_match('/^0\d{9}$/', $digits)) {
            $digits = '380' . substr($digits, 1);
        }

        if (strlen($digits) >= 10 && strlen($digits) <= 12) {
            return $digits;
        }

        return $data;
    }


    /**
     * @param array $data
     * @return array
     */
    public static function getAssocArray(array $data): array
    {
        $assocArray = [];

        $headers = array_map('trim', array_shift($data));

        foreach ($data as $row) {
            $values = array_map('trim', $row);

            if (count($values) !== count($headers)) {
                continue;
            }

            $assocArray[] = array_combine($headers, $values);
        }

        return $assocArray;
    }



}