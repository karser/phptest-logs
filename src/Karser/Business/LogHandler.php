<?php
namespace Karser\Business;

class LogHandler
{
    /** @var \SplFileObject */
    private $file;

    public function load($path)
    {
        $this->file = new \SplFileObject($path);
        $this->file->setFlags(\SplFileObject::READ_AHEAD);
        $this->file->setFlags(\SplFileObject::SKIP_EMPTY);
        foreach ($this->file as $row) {
            if ($ipStat = $this->parseRow($row)) {
                $this->ips[] = $ipStat->getIp();
                $this->ipsByDate[$ipStat->getDate()][] = $ipStat->getIp();
            }
        }
    }

    private $ips = [];
    private $ipsByDate = [];

    private function parseRow($row)
    {
        $regex = '/^(\S+) (\S+) (\S+) \[([^:]+):(\d+:\d+:\d+) ([^\]]+)\] \"(\S+) (.*?) (\S+)\" (\S+) (\S+) "([^"]*)" "([^"]*)"$/';
        if (!preg_match($regex ,$row, $matches)) {
            return false;
        }
        return new IpStat($matches[1], $matches[4]);
    }

    public function getStats()
    {
        $stat = [];
        foreach ($this->ipsByDate as $date => $ips) {
            $hits = count($ips);
            $unique = count(array_unique($ips));
            $stat[] = [
                'date' => $date,
                'hits' => $hits,
                'unique' => $unique
            ];
        }
        $allUnique = count(array_unique($this->ips));
        $allHits = count($this->ips);
        $stat['hit_per_unique'] = $allUnique > 0 ? $allHits/$allUnique : 0;
        return $stat;
    }
}