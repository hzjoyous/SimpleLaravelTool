<?php
declare(strict_types=1);

namespace App\RemoteService\VipRemoteService;


class UserVipInfoFromVRS
{
    const member365  = '';
    const experience = '';

    /**
     * @var int
     */
    private $isVip = 0;
    /**
     * @var string
     */
    private $validityTime = 'validityTime';
    /**
     * @var string
     */
    private $vipType = 'memberType';
    /**
     * @var string
     */
    private $validityDay = '1970';
    /**
     * @var array
     */
    private $vipFee = [

    ];

    /**
     * UserVipInfoFromVRS constructor.
     * @param $isVip
     * @param $validityDay
     * @param $vipType
     * @param $validityTime
     * @param $vipFee
     */
    public function __construct(int $isVip, string $validityDay, string $vipType, string $validityTime, array $vipFee)
    {
        $this->setIsVip($isVip)->setValidityDay($validityDay)->setVipType($vipType)->setValidityTime($validityTime)->setVipFee($vipFee);
    }

    /**
     * @return int
     */
    public function getIsVip(): int
    {
        return $this->isVip;
    }

    /**
     * @param int $isVip
     * @return UserVipInfoFromVRS
     */
    private function setIsVip(int $isVip): UserVipInfoFromVRS
    {
        $this->isVip = $isVip;
        return $this;
    }

    /**
     * @return string
     */
    public function getValidityTime(): string
    {
        return $this->validityTime;
    }

    /**
     * @param string $validityTime
     * @return UserVipInfoFromVRS
     */
    private function setValidityTime(string $validityTime): UserVipInfoFromVRS
    {
        $this->validityTime = $validityTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getVipType(): string
    {
        return $this->vipType;
    }

    /**
     * @param string $vipType
     * @return UserVipInfoFromVRS
     */
    private function setVipType(string $vipType): UserVipInfoFromVRS
    {
        $this->vipType = $vipType;
        return $this;
    }

    /**
     * @return string
     */
    public function getValidityDay(): string
    {
        return $this->validityDay;
    }

    /**
     * @param string $validityDay
     * @return UserVipInfoFromVRS
     */
    private function setValidityDay(string $validityDay): UserVipInfoFromVRS
    {
        $this->validityDay = $validityDay;
        return $this;
    }

    /**
     * @return array
     */
    public function getVipFee(): array
    {
        return $this->vipFee;
    }

    /**
     * @param array $vipFee
     * @return UserVipInfoFromVRS
     */
    private function setVipFee(array $vipFee): UserVipInfoFromVRS
    {
        $this->vipFee = $vipFee;
        return $this;
    }


}
