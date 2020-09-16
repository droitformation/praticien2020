<div class="card">
    <div class="card-body">
        <table id="users" class="table table-condensed">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Status</th>
                <th>Rôle</th>
                <th>Gestion</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <i class="text-{{ $user->valid ? 'success' : 'warning' }} fas fa-{{ $user->valid ? 'check' : 'times' }}"></i>&nbsp;
                        {{ isset($user->active_until) ? $user->active_until->format('Y-m-d') : '' }}
                    </td>
                    <td>{{ $user->role }}</td>
                    <td align="right"><a href="{{ secure_url('backend/user/'.$user->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> &nbsp;Voir</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div><!-- card-body -->
</div><!-- card -->
