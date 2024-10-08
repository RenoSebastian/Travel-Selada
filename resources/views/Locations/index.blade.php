<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matching Locations</title>
</head>
<body>
    <h1>Matching Locations</h1>

    <p>User ID: {{ $userId }}</p>
    <p>Location ID: {{ $locationId }}</p>

    <h2>Matching Member Data:</h2>
    @if($matchingMembers->isEmpty())
        <p>No matching locations found.</p>
    @else
                              @foreach($matchingMembers as $member)
                <li>{{ $member->fullname }} (ID: {{ $member->id }})  Nomor Telepon: {{ $member->phone }} Seat : {{ $member->code }} </li>
            @endforeach
        </ul>
    @endif
</body>
</html>
