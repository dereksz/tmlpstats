<?php
namespace TmlpStats;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;

class TmlpRegistrationData extends Model
{
    use CamelCaseModel;

    protected $table = 'tmlp_registrations_data';

    protected $fillable = [
        'stats_report_id',
        'tmlp_registration_id',
        'reg_date',
        'app_out_date',
        'app_in_date',
        'appr_date',
        'wd_date',
        'withdraw_code_id',
        'committed_team_member_id',
        'comment',
        'incoming_quarter_id',
        'travel',
        'room',
    ];

    protected $dates = [
        'reg_date',
        'app_out_date',
        'app_in_date',
        'appr_date',
        'wd_date',
    ];

    public function __get($name)
    {
        switch ($name) {

            case 'firstName':
            case 'lastName':
                return $this->registration->person->$name;
            default:
                return parent::__get($name);
        }
    }

    public function due()
    {
        if ($this->withdrawCodeId || $this->apprDate) {
            return null;
        } else if ($this->appInDate) {
            $regDate = clone $this->regDate;
            return $regDate->addDays(14);
        } else if ($this->appOutDate) {
            $regDate = clone $this->regDate;
            return $regDate->addDays(14);
        } else {
            $regDate = clone $this->regDate;
            return $regDate->addDays(2);
        }
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull('appr_date');
    }

    public function scopeWithdrawn($query)
    {
        return $query->whereNotNull('wd_date');
    }

    public function scopeIncomingQuarter($query, Quarter $quarter)
    {
        return $query->whereIncomingQuarterId($quarter->id);
    }

    public function scopeByStatsReport($query, StatsReport $statsReport)
    {
        return $query->whereStatsReportId($statsReport->id);
    }

    public function statsReport()
    {
        return $this->belongsTo('TmlpStats\StatsReport');
    }

    public function withdrawCode()
    {
        return $this->belongsTo('TmlpStats\WithdrawCode');
    }

    public function committedTeamMember()
    {
        return $this->belongsTo('TmlpStats\TeamMember', 'committed_team_member_id', 'id');
    }

    public function incomingQuarter()
    {
        return $this->belongsTo('TmlpStats\Quarter', 'id', 'incoming_quarter_id');
    }

    public function registration()
    {
        return $this->belongsTo('TmlpStats\TmlpRegistration', 'tmlp_registration_id', 'id');
    }
}
