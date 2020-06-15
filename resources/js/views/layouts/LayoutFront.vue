<template>
  <div class="template-container">
    <header class="site-header">
      <a href="#" class="brand-main"> <b>PHẦN DÀNH CHO KHÁCH HÀNG</b></a>

      <ul class="action-list">
        <li>
          <v-dropdown :show-arrow="false">
            <a
              slot="activator"
              href="#"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              class="avatar"
            >
              <img src="/assets/img/avatars/avatar_default.jpg" alt="Avatar">
            </a>
            <v-dropdown-item>
              <router-link class="dropdown-item" to="#HoSo">
                <i class="icon-fa icon-fa-cogs"/> Hồ sơ
              </router-link>
            </v-dropdown-item>
            <v-dropdown-item>
              <a
                href="#"
                class="dropdown-item"
                @click.prevent="logout"
              >
                <i class="icon-fa icon-fa-sign-out"/> Đăng xuất
              </a>
            </v-dropdown-item>
          </v-dropdown>
        </li>
      </ul>
      <ul class="action-list">
        <li class="action-item">
          <router-link to="/admin/">Truy cập trang admin</router-link>
        </li>
      </ul>
    </header>
    <transition
      name="fade"
      mode="out-in">
      <router-view/>
    </transition>
  </div>
</template>

<script type="text/babel">
  import Auth from '../../services/auth'

  export default {
    methods: {
      onNavToggle () {
        this.$utils.toggleSidebar()
      },
      logout () {
        Auth.logout().then(() => {
          this.$router.replace('/login')
        })
      }
    }
  }
</script>
