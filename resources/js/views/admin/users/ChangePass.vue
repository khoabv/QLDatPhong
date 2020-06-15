<template>
  <div class="main-content add-users">
    <div class="page-header">
      <h3 class="page-title">Thay đổi mật khẩu</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Tài khoản cá nhân</a></li>
        <li class="breadcrumb-item active">Đổi mật khẩu</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h6>Thông tin mật khẩu</h6>
          </div>
          <div class="card-body">
              <div class="form-group">
                <label class="required">Mật khẩu cũ</label>
                <input
                  v-model.trim="changePassData.password"
                  type="password"
                  class="form-control"
                  name="password"
                  placeholder="Nhập mật khẩu"
                >
                <div class="message_invalid">
                  {{ message.password }}
                </div>
              </div>

              <div class="form-group">
                <label class="required">Mật khẩu mới</label>
                <input
                  v-model.trim="changePassData.newPassword"
                  type="password"
                  class="form-control"
                  name="password"
                  placeholder="Nhập mật khẩu"
                >
                <div class="message_invalid">
                  {{ message.newPassword }}
                </div>
              </div>

              <div class="form-group">
                <label class="required">Xác nhận mật khẩu mới</label>
                <input
                  v-model.trim="changePassData.newPasswordConfirm"
                  type="password"
                  class="form-control"
                  name="password"
                  placeholder="Nhập lại mật khẩu"
                >
                <div class="message_invalid">
                  {{ message.newPasswordConfirm }}
                </div>
              </div>

              <div class="form-group">
                <button class="btn btn-success" @click="validateBeforeSubmit()">
                  Lưu
                </button>
                <router-link to="/">
                  <a class="btn btn-secondary">
                    Hủy
                  </a>
                </router-link>
              </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  import Auth from '../../../services/auth'

  export default {
    data () {
      return {
        changePassData: {
          idUser: '',
          password: '',
          newPassword: '',
          newPasswordConfirm: ''
        },
        message: {
          password: '',
          newPassword: '',
          newPasswordConfirm: ''
        }
      }
    },
    created: function () {
      /*this.getUserById(this.$route.params.id)*/
    },
    methods: {
      async validateBeforeSubmit () {
        console.log("called validate and submit function")
        if (this.validate() === true) {
          // eslint-disable-next-line no-unused-vars,no-undef
          let response = await axios.post('/api/changeMyPass', this.changePassData)
          if (response.data.result === true) {
            window.toastr['success'](response.data.message, 'Success')
            Auth.logout().then(() => {
              this.$router.replace('/login')
            })
          } else window.toastr['error'](response.data.message, 'Error')
        }
      },
      validate () {
        this.message.password = ''
        this.message.newPassword = ''
        this.message.newPasswordConfirm = ''
        let resultCheck = true
        if (this.changePassData.password === '' || this.changePassData.password === null || typeof (this.changePassData.password) === 'undefined') {
          this.message.password = 'Trường không được để trống!'
          resultCheck = false
        }
        if (this.changePassData.newPassword === '' || this.changePassData.newPassword === null || typeof (this.changePassData.newPassword) === 'undefined') {
          this.message.newPassword = 'Trường không được để trống!'
          resultCheck = false
        }
        if (this.changePassData.newPasswordConfirm === '' || this.changePassData.newPasswordConfirm === null || typeof (this.changePassData.newPasswordConfirm) === 'undefined') {
          this.message.passwordConfirm = 'Trường không được để trống!'
          resultCheck = false
        } else if (this.changePassData.newPasswordConfirm !== this.changePassData.newPassword) {
          this.message.passwordConfirm = 'Xác nhận mật khẩu không đúng!'
          resultCheck = false
        }

        return resultCheck
      }
    }
  }
</script>

<!--<style scoped>

</style>-->
