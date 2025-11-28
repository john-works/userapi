@php
    use App\Helpers\DataLoader;
    $users = DataLoader::allUsers()->result;
@endphp
<table class="---data-table important-contacts table table-striped table-bordered table-hover no-margin-bottom no-border-top" id="important-contacts" style="width: 100% !important;">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Department</th>
            <th>Staff Extension</th>
            <th>Phone 1</th>
            <th>Phone 2</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ @$user->firstName }}</td>
                <td>{{ @$user->lastName }}</td>
                <td>{{ @$user->departmentName }}</td>
                <td>{{ @$user->phone }}</td>
                <td>{{ @$user->phone_1 }}</td>
                <td>{{ @$user->phone_2 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function(){
        $('#important-contacts').DataTable();
    })
</script>