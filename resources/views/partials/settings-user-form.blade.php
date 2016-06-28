<div class="user-form">
  <form method="post" enctype="multipart/form-data" action="{{ !isset($user)?
    route('settings.userstore', ['company' => $company]):
    route('settings.userupdate', ['user' => $user, 'company' => $company]) }}">
    <h5>{{ isset($user)? 'EDIT USER': 'NEW USER' }}</h5>

    {{ csrf_field() }}
    <input type="hidden" name="_method" value="{{ isset($user)? 'PUT': 'POST'}}" />
    <div class="row">
      <div class="large-12 columns">
        <label>Name
          <input type="text" name="name" value="{{ $user->name or '' }}" />
        </label>
      </div>
      <div class="large-12 columns">
        <label>Email
          <input type="text" name="email" value="{{ $user->email or '' }}" />
        </label>
      </div>
      <div class="large-12 columns">
        <label>Password
          <input type="password" name="password" value="" />
        </label>
      </div>
      <div class="large-12 columns">
        <label>Picture
          <input type="file" name="icon" />
        </label>
      </div>
      @if(!isset($user))
      <div class="large-12 columns">
        <label>Role
          <select name="role">
            <option value="{{ \Treabar\Models\User::ROLE_DEV }}">Developer</option>
            <option value="{{ \Treabar\Models\User::ROLE_MANAGER }}">Manager</option>
            <option value="{{ \Treabar\Models\User::ROLE_CLIENT }}">Client</option>
          </select>
        </label>
      </div>
      @endif
    </div>
    <div class="form-buttons">
      <input type="submit" value="Save" class="button tiny" />
    </div>
  </form>
</div>