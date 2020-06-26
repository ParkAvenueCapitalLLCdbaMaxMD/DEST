<?php
/**
 * @Desc:
 * @Auth: Yan Wang <ywang@max.md>
 * @Date: 3/18/20
 * @Copy: (c) Copyright 2020 Park Avenue Capital LLC dba MaxMD, All Rights Reserved.
 *
 *  Redistribution and use in source and binary forms, with or without  modification,
 *  are permitted provided that the following conditions  are met:
 *
 *  1. Redistributions of source code must retain the above copyright
 *  notice, this list of conditions and the following disclaimer.
 *
 *  2. Redistributions in binary form must reproduce the above copyright
 *  notice, this list of conditions and the following disclaimer in
 *  the documentation and/or other materials provided with the
 *  distribution.
 *
 *  3. Neither the name of the copyright holder nor the names of its
 *  contributors may be used to endorse or promote products derived
 *  from this software without specific prior written permission.
 *
 *  4. Redistributions of any form whatsoever must retain the following
 *  acknowledgment: 'This product includes software developed by
 *  "MaxMD".
 *
 *  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS  "AS IS"
 *  AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT  LIMITED TO, THE
 *  IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR  A PARTICULAR PURPOSE
 *  ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  HOLDER OR CONTRIBUTORS BE
 *  LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,  SPECIAL, EXEMPLARY, OR
 *  CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED  TO, PROCUREMENT OF
 *  SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR  PROFITS; OR BUSINESS
 *  INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF  LIABILITY, WHETHER IN
 *  CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING  NEGLIGENCE OR OTHERWISE)
 *  ARISING IN ANY WAY OUT OF THE USE OF THIS  SOFTWARE, EVEN IF ADVISED OF
 *  THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

namespace EmiAdvisors;

use EmiAdvisors\Base\SdohDomain as BaseSdohDomain;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Propel;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Skeleton subclass for representing a row from the 'sdoh_domain' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class SdohDomain extends BaseSdohDomain
{
    const STATUS_CLOSED = "Closed";
    const STATUS_OPEN = "Open";
    const STATUS_TESTING = "Testing";
    const ACTION_OPEN = 'open';
    const ACTION_CLOSE = 'close';

    const SCHEDULE_STATUS_ACTIVE = 'active';
    const SCHEDULE_STATUS_COMPLETED = 'completed';
    const SCHEDULE_STATUS_FAILED = 'failed';
    const SCHEDULE_STATUS_DISABLED = 'disabled';
    public function addLog($message, $whoami, $level = "info"){
        $log = [
            'time' => date('Y-m-d H:i:s', time()),
            'message' => $message,
            'whoami' => $whoami,
            'level' => $level
        ];
        $logs = $this->getLogsAsArray();
        $logs[] = $log;
        $this->setLogsAsArray($logs);
        return $log;
    }

    public function getLogsAsArray(){
        $logsText = $this->getLogs();
        if (is_null($logsText) || $logsText == ""){
            $logsText = "[]";
        }
        return json_decode($logsText, true);
    }

    public function setLogsAsArray($array){
        $this->setLogs(json_encode($array));
    }

    public function getDomainRelatedForms(){
        return SdohFormQuery::create()->filterByDomain($this->getName())->filterByValid(1)
            ->withColumn("count(*)", "Count")
            ->select(["Count", "status"])
            ->groupByStatus()
            ->find()
            ->toArray();
    }

    public function getSchedulesAsArray(){
        $scheduleContent = $this->getSchedules();
        if (is_null($scheduleContent) || $scheduleContent == ""){
            $scheduleContent  = "{}";
        }
        $schedules = json_decode($scheduleContent, true);
        foreach ($schedules as $action => $record){
            if (!isset($record['action'])){
                $schedules[$action]['action'] = $action;
            }
            if (!isset($record['status'])){
                $schedules[$action]['status'] = self::SCHEDULE_STATUS_ACTIVE;
            }
        }

        return $schedules;
    }

    public function getActiveSchedule(){
        $schedules= $this->getSchedulesAsArray();
        $nowMS = time() * 1000;

        // check close first, then check open schedule.
        // because if open and close are both current, run closed.
        if (isset($schedules[self::ACTION_CLOSE]['time'])){
            $s = $schedules[self::ACTION_CLOSE];
            $status = isset($s['status']) ? $s['status'] : self::SCHEDULE_STATUS_ACTIVE;

            if ($status == self::SCHEDULE_STATUS_ACTIVE && $s['time'] <= $nowMS){
                // not accomplished, scheduled time is current
                if ($this->getStatus() !== self::STATUS_CLOSED){
                    return $s;
                }
            }
        }
        if (isset($schedules[self::ACTION_OPEN]['time'])){
            $s = $schedules[self::ACTION_OPEN];
            $status = isset($s['status']) ? $s['status'] : self::SCHEDULE_STATUS_ACTIVE;
            if ($status == self::SCHEDULE_STATUS_ACTIVE && $s['time'] <= $nowMS){
                // not accomplished, scheduled time is current
                if ($this->getStatus() !== self::STATUS_OPEN){
                    return $s;
                }
            }
        }
        return null;
    }

    public function openDomain(User $user, $con = null){
        if (is_null($con)){
            $autocommit = true;
            $con = Propel::getConnection();
        } else {
            $autocommit = false;
        }
        try{
            if ($autocommit){
                $con->beginTransaction();
            }

            $nowMS = time() * 1000;
            $schedules = $this->getSchedulesAsArray();
            $newSchedules = [];
            foreach ($schedules as $action => $s){
                if ($s['action'] === self::ACTION_OPEN){
                    $s['status'] = self::SCHEDULE_STATUS_COMPLETED;
                } else if ($s['time'] < $nowMS) {
                    // disable other current schedules
                    $s['status'] = self::SCHEDULE_STATUS_DISABLED;
                }
                $newSchedules[$action] = $s;
            }

            $oldStatus = $this->getStatus();
            $this->setStatus(self::STATUS_OPEN);
            $this->setSchedules(json_encode($newSchedules));
            $this->addLog(sprintf("Updated status from %s to %s as scheduled", $oldStatus, $this->getStatus()), sprintf("%s <%s>", $user->getName(), $user->getEmail()));
            $this->save($con);

            if ($autocommit){
                $con->commit();
            }
        } catch (Exception $ex){
            if ($autocommit){
                $con->rollBack();
            }
            throw $ex;
        }
    }

    public function closeDomain(User $user, $con = null){
        if (is_null($con)){
            $autocommit = true;
            $con = Propel::getConnection();
        } else {
            $autocommit = false;
        }
        try{
            if ($autocommit){
                $con->beginTransaction();
            }

            $nowMS = time() * 1000;
            $schedules = $this->getSchedulesAsArray();
            $newSchedules = [];
            foreach ($schedules as $action => $s){
                if ($s['action'] === self::ACTION_CLOSE){
                    $s['status'] = self::SCHEDULE_STATUS_COMPLETED;
                } else if ($s['time'] < $nowMS) {
                    // disable other current schedules
                    $s['status'] = self::SCHEDULE_STATUS_DISABLED;
                }
                $newSchedules[$action] = $s;
            }
            $oldStatus = $this->getStatus();
            $this->setStatus(self::STATUS_CLOSED);
            $this->setSchedules(json_encode($newSchedules));
            $this->addLog(sprintf("Updated status from %s to %s as scheduled", $oldStatus, $this->getStatus()), sprintf("%s <%s>", $user->getName(), $user->getEmail()));
            $this->save($con);

            if ($autocommit){
                $con->commit();
            }
        } catch (Exception $ex){
            if ($autocommit){
                $con->rollBack();
            }
            throw $ex;
        }
    }

    public static function getDomainListForUser(User $user){
        $query = SdohDomainQuery::create();
        if ($user->getRole() !== "Admin"){
            $query->filterByStatus(self::STATUS_OPEN, Criteria::EQUAL);
        } else {
            $query->filterByStatus([self::STATUS_TESTING, self::STATUS_OPEN], Criteria::IN);
        }
        return $query->find()->getData();
    }

    public static function getUnableToCreateFormOnClosedDomainException(){

        $btn = "<a target='_blank' href='mailto:gravityproject@emiadvisors.net'>gravityproject@emiadvisors.net</a>";
        return new Exception("Data element submission for this content domain is now closed.  To submit data element input or feedback for this domain, please send email to Gravity Project $btn");
    }

}
