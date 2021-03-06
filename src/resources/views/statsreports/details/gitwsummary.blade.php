<div class="table-responsive">
    <br/>
    <table class="table table-condensed table-bordered">
        <thead>
        <tr>
            <th style="vertical-align: middle">Name</th>
            <th style="text-align: center; width: 5em">Team Year</th>
            @foreach ($reportData['dates'] as $date)
                <th style="vertical-align: middle; text-align: center">{{ $date->format('M j') }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach ($reportData['members'] as $id => $memberRow)
            @if ($memberRow['withdrawn'] == false)
                <tr>
                    <td>{{ $memberRow['member']->firstName }} {{ $memberRow['member']->lastName }}</td>
                    <td style="text-align: center">T{{ $memberRow['member']->teamYear }}Q{{ $memberRow['member']->quarterNumber }}</td>
                    @foreach ($reportData['dates'] as $date)
                        <?php $data = isset($memberRow[$date->toDateString()]) ? $memberRow[$date->toDateString()] : null; ?>
                        @if ($data === null)
                            <td class="active" style="color: #006000; text-align: center">
                                <span class="glyphicon glyphicon-minus"></span>
                            </td>
                        @elseif ($data['effective'])
                            <td class="success" style="color: #006000; text-align: center">
                                <span class="glyphicon glyphicon-ok"></span>
                            </td>
                        @else
                            <td class="danger" style="color: #a00000; text-align: center">
                                <span class="glyphicon glyphicon-remove"></span>
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>
