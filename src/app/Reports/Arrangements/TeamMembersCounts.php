<?php namespace TmlpStats\Reports\Arrangements;

class TeamMembersCounts extends BaseArrangement
{

    /* Builds an array of TDO attendance for each team member
     *
     */
    public function build($data)
    {
        $teamMembersData = $data['teamMembersData'];

        $tdo = [
            'team1' => 0,
            'team2' => 0,
            'total' => 0,
        ];

        $gitw = [
            'team1' => 0,
            'team2' => 0,
            'total' => 0,
        ];

        $withdraws = [
            'team1' => 0,
            'team2' => 0,
            'total' => 0,
            'ctw'   => 0,
            'codes' => [],
        ];

        $totals = [
            'team1' => 0,
            'team2' => 0,
        ];
        $reportData = [];
        foreach ($teamMembersData as $data) {
            if ($data->teamMember->teamYear == 1) {
                $totals['team1']++;

                if ($data->tdo) {
                    $tdo['team1']++;
                    $tdo['total']++;
                }

                if ($data->gitw) {
                    $gitw['team1']++;
                    $gitw['total']++;
                }

                if ($data->withdrawCode) {
                    $withdraws['team1']++;
                    $withdraws['total']++;
                    if (isset($withdraws['codes'][$data->withdrawCode->display])) {
                        $withdraws['codes'][$data->withdrawCode->display]++;
                    } else {
                        $withdraws['codes'][$data->withdrawCode->display] = 1;
                    }
                } else if ($data->ctw) {
                    $withdraws['ctw']++;
                }
            } else {
                $totals['team2']++;

                if ($data->tdo) {
                    $tdo['team2']++;
                    $tdo['total']++;
                }

                if ($data->gitw) {
                    $gitw['team2']++;
                    $gitw['total']++;
                }

                if ($data->withdrawCode) {
                    $withdraws['team2']++;
                    $withdraws['total']++;
                    if (isset($withdraws['codes'][$data->withdrawCode->display])) {
                        $withdraws['codes'][$data->withdrawCode->display]++;
                    } else {
                        $withdraws['codes'][$data->withdrawCode->display] = 1;
                    }
                } else if ($data->ctw) {
                    $withdraws['ctw']++;
                }
            }
        }

        $t1Total = $totals['team1'] - $withdraws['team1'];
        $t2Total = $totals['team2'] - $withdraws['team2'];
        $total = $t1Total + $t2Total;

        if ($t1Total) {
            $tdo['team1'] = round(($tdo['team1'] / $t1Total) * 100);
            $gitw['team1'] = round(($gitw['team1'] / $t1Total) * 100);
        }
        if ($t2Total) {
            $tdo['team2'] = round(($tdo['team2'] / $t2Total) * 100);
            $gitw['team2'] = round(($gitw['team2'] / $t2Total) * 100);
        }
        if ($t1Total + $t2Total) {
            $tdo['total'] = round(($tdo['total'] / $total) * 100);
            $gitw['total'] = round(($gitw['total'] / $total) * 100);
        }

        $reportData['tdo'] = $tdo;
        $reportData['gitw'] = $gitw;
        $reportData['withdraws'] = $withdraws;
        $reportData['totals'] = $totals;

        return compact('reportData');
    }
}
