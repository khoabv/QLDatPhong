<template>
  <header class="site-header-public">
    <a href="#" class="brand-main" style="color: white"> <b>PHẦN DÀNH CHO KHÁCH HÀNG</b></a> <a href="#"
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

    <ul class="action-list">
      <li class="action-item">
        <router-link to="/admin/">Truy cập trang admin</router-link>
      </li>
    </ul>
  </header>
</template>
<script type="text/babel">
  import Auth from '../../../../services/auth'
  import {required, minLength, email} from 'vuelidate/lib/validators'
  import Ls from '../../../../services/ls'

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
      /*async getUserLoggon(){
        Auth.check()
      }*/
    }
  }
</script>

<!--<script>
  import {required, minLength, email} from 'vuelidate/lib/validators'
  import Ls from '../../../services/ls'

  export default {
    data () {
      return {
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
      async getUserLoggonInLs () {
        this.userLoggon.email = Ls.get("email");
        this.userLoggon.role = Ls.get("role");
        console.log("email = "+this.userLoggon.email)
        console.log("role = "+this.userLoggon.role)
      },
    }
  }
</script>-->
