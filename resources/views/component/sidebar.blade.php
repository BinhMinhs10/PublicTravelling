<h1>New User</h1>
<hr>
<div>
	<ul>
		@foreach( $users as $user)
			<li>
				<a href="users/{{ $user->id }}" class="custm-fix-link-light">
				<div style="background-image: url('{{asset($user->avatar)}}');" class="row marleft15 marbot25 marright15 img-thumbnail user-div">
					<div class="col-md-4 martop15 img-div">
						<img src="{{ asset($user->avatar) }}" class="cycle-200" />
					</div>
					<div class="col-md-8 martop80 info-div">
						<h5>{{ $user->fullname }}</h5>
						<p>{{ $user->email }}</p>
					</div>
				</div>
				</a>				
			</li>
		@endforeach
	</ul>
</div>

