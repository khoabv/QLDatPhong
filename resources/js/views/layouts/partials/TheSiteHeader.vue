<template>
  <header class="site-header">
    <a href="#" class="brand-main"> <b>PHẦN DÀNH CHO QUẢN LÝ</b></a> <a href="#"
                                                                                                class="nav-toggle">
    <div class="hamburger hamburger--htla"><span>toggle menu</span></div>
  </a>
    <ul class="action-list" style="margin-top: 10px">

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
            {{userLoggon.email}}
            <!--<img src="/assets/img/avatars/avatar_default.jpg" alt="Avatar">-->
          </a>
          <v-dropdown-item>
            <router-link class="dropdown-item" to="/changeMyPass">
              <i class="icon-fa icon-fa-cogs"/> Đổi mật khẩu
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
  </header>
  <!--<header class="site-header">
    <a href="#" class="brand-main">
      <h2>PHẦN MỀM QUẢN LÝ PHÒNG HỌP</h2>
    </a>
    <a
      href="#"
      class="nav-toggle"
      @click="onNavToggle"
    >
      <div class="hamburger hamburger&#45;&#45;arrowturn">
        <div class="hamburger-box">
          <div class="hamburger-inner"/>
        </div>
      </div>
    </a>
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
            <img src="/assets/img/avatars/avatar.png" alt="Avatar">
          </a>
          &lt;!&ndash;<v-dropdown-item>
            <router-link class="dropdown-item" to="/admin/settings">
              <i class="icon-fa icon-fa-cogs"/> Settings
            </router-link>
          </v-dropdown-item>&ndash;&gt;
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
  </header>-->
</template>
<script type="text/babel">
  import Auth from '../../../services/auth'
  import Ls from '../../../services/ls'

  export default {
    data () {
      return {
        user: {},
        userLoggon:{
          email:"",
          role:""
        }
      }
    },
    created: function () {
      this.getUserLoggonInLs()
    },
    methods: {
      onNavToggle () {
        this.$utils.toggleSidebar()
      },
      logout () {
        Auth.logout().then(() => {
          this.$router.replace('/login')
        })
      },
      async getUserLoggonInLs () {
        this.userLoggon.email = Ls.get("email");
        this.userLoggon.role = Ls.get("role");
        console.log("email = "+this.userLoggon.email)
        console.log("role = "+this.userLoggon.role)
      }
    }
  }
</script>
