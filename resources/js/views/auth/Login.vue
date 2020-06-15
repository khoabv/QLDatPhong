<template>
  <form @submit.prevent="validateBeforeSubmit">
    <div :class="['form-group', {'is-invalid': $v.loginData.email.$error}]">
      <input
        :class="{ 'is-invalid': $v.loginData.email.$error }"
        v-model.trim="loginData.email"
        class="form-control"
        placeholder="Nhập Email"
        type="email"
        @input="$v.loginData.email.$touch()"
      >
      <span v-if="!$v.loginData.email.required" class="invalid-feedback">
        Email không được để trống
      </span>
      <span v-if="!$v.loginData.email.email" class="invalid-feedback">
        Email không chính xác
      </span>
    </div>
    <div :class="['form-group', {'is-invalid': $v.loginData.password.$error}]">
      <input
        :class="{ 'is-invalid': $v.loginData.password.$error }"
        v-model.trim="loginData.password"
        class="form-control"
        placeholder="Enter Password"
        type="password"
        @input="$v.loginData.password.$touch()"
      >
      <span v-if="!$v.loginData.password.required" class="invalid-feedback">
        Password is required
      </span>
      <span v-if="!$v.loginData.password.minLength" class="invalid-feedback">
        Mật khẩu phải có tối thiếu {{ $v.loginData.password.$params.minLength.min }} ký tự.
      </span>
    </div>
    <div class="other-actions row">
      <div class="col-sm-6">
        <div class="checkbox">
          <label class="c-input c-checkbox">
            <input
              v-model="loginData.remember"
              type="checkbox"
              name="remember"
            >
            <span class="c-indicator"/>
            Ghi nhớ đăng nhập
          </label>
        </div>
      </div>
      <div class="col-sm-6 text-sm-right">
        <a href="#" class="forgot-link">
          Quên mật khẩu?
        </a>
      </div>
    </div>
    <button class="btn btn-theme btn-full">Đăng nhập</button>
  </form>
</template>

<script type="text/babel">
import {required, minLength, email} from 'vuelidate/lib/validators'
import Auth from '../../services/auth'
import Ls from '../../services/ls'

export default {
  data () {
    return {
      loginData: {
        email: 'admin@gmail.com',
        password: 'Admin123456',
        remember: ''
      }
    }
  },
  validations: {
    loginData: {
      password: {
        required,
        minLength: minLength(6)
      },
      email: {
        required,
        email
      }
    }
  },
  methods: {
    validateBeforeSubmit () {
      this.$v.$touch()

      if (!this.$v.$error) {
        Auth.login(this.loginData).then((res) => {
          if (res) {
            this.getUserLoggon()
            //this.$router.push('/')
          }
        })
      }
    },
    async getUserLoggon () {
      try {
        // eslint-disable-next-line no-undef
        const response = await axios.get(`/api/auth/getUserLoggedOn`)
        /*this.user = response.data*/
        Ls.set('email', response.data.user.email)
        Ls.set('role', response.data.user.role)
        console.log("data user loggon = "+response.data.user.email)

        this.$router.push('/')
      } catch (error) {
        if (error) {
          window.toastr['error']('Có lỗi xảy ra', 'Error')
        }
      }
    }
  }
}
</script>
