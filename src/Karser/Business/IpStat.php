<?php
namespace Karser\Business;


class IpStat
{
    /** @var string */
    private $ip;

    /** @var string */
    private $date;

    /**
     * @param string $ip
     * @param string $date
     */
    public function __construct($ip, $date)
    {
        $this->ip = $ip;
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
}