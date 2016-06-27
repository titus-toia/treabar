<div class="user-form">
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
        <input type="text" name="password" value="" />
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
</div>