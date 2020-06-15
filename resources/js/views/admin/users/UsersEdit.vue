<template>
  <div class="main-content add-users">
    <div class="page-header">
      <h3 class="page-title">Chỉnh sửa người dùng</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Quản lý người dùng</a></li>
        <li class="breadcrumb-item active">Chỉnh sửa</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h6>Thông tin người dùng</h6>
          </div>
          <div class="card-body">
              <div :class="{'form-group' : true}">
                <label class="required">Họ tên</label>
                <input
                  v-model.trim="userUpdateData.name"
                  type="text"
                  class="form-control"
                  name="name"
                  placeholder="Nhập tên"
                >
                <div class="message_invalid">
                  {{ message.name }}
                </div>
              </div>

              <div :class="{'form-group' : true}">
                <label class="required">Email</label>
                <input
                  v-model.trim="userUpdateData.email"
                  type="text"
                  class="form-control"
                  name="email"
                  placeholder="Nhập email"
                >
                <div class="message_invalid">
                  {{ message.email }}
                </div>
              </div>

              <div class="form-group">
                <label class="">Mật khẩu mới</label>
                <input
                  v-model.trim="userUpdateData.password"
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
                <label class="">Xác nhận mật khẩu mới</label>
                <input
                  v-model.trim="userUpdateData.passwordConfirm"
                  type="password"
                  class="form-control"
                  name="password"
                  placeholder="Nhập lại mật khẩu"
                >
                <div class="message_invalid">
                  {{ message.passwordConfirm }}
                </div>
              </div>

              <div class="form-group">
                <label class="required">Quyền</label>
                <select v-model = "userUpdateData.role" class="custom-select">
                  <option value="user">Người dùng</option>
                  <option value="admin">Quản trị</option>
                </select>
                <div class="invalid-feedback">
                  {{ message.role }}
                </div>
              </div>

              <div class="form-group">
                <label class="required">Trạng thái</label>
                <select v-model = "userUpdateData.isActive" class="custom-select">
                  <option value="1">Kích hoạt</option>
                  <option value="0">Tạm khóa</option>
                </select>
              </div>

              <div class="form-group">
                <button class="btn btn-success" @click="validateBeforeSubmit()">
                  Lưu
                </button>
                <router-link to="/users/all">
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
  export default {
    data () {
      return {
        userUpdateData: {
          id: '',
          name: '',
          email: '',
          password: '',
          passwordConfirm: '',
          role: '',
          isActive: '',
          isChangePass: false
        },
        message: {
          name: '',
          email: '',
          password: '',
          passwordConfirm: '',
          role: ''
        }
      }
    },
    created: function () {
      this.getUserById(this.$route.params.id)
    },
    methods: {
      async getUserById (id) {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/users/get/${id}`)
          this.userUpdateData = response.data
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async validateBeforeSubmit () {
        if (this.validate() === true) {
          // eslint-disable-next-line no-unused-vars,no-undef
          let response = await axios.post('/api/admin/users/update', this.userUpdateData)
          if (response.data.result === true) {
            window.toastr['success'](response.data.message, 'Success')
            window.location.href = '/admin/users/all'
          } else window.toastr['error'](response.data.message, 'Error')
        }
      },
      validate () {
        this.message.name = ''
        this.message.email = ''
        this.message.password = ''
        this.message.passwordConfirm = ''
        this.message.role = ''
        let resultCheck = true
        this.userUpdateData.isActive=false;
        if (this.userUpdateData.name === '' || this.userUpdateData.name === null || typeof (this.userUpdateData.name) === 'undefined') {
          this.message.name = 'Trường không được để trống!'
          resultCheck = false
        }
        if (this.userUpdateData.email === '' || this.userUpdateData.email === null || typeof (this.userUpdateData.email) === 'undefined') {
          this.message.email = 'Trường không được để trống!'
          resultCheck = false
        }
        if (this.userUpdateData.role === '' || this.userUpdateData.role === null || typeof (this.userUpdateData.role) === 'undefined') {
          this.message.role = 'Trường không được để trống!'
          resultCheck = false
        }

        if(this.userUpdateData.password!='' && this.userUpdateData.password!=null){
          if (this.userUpdateData.passwordConfirm === '' || this.userUpdateData.passwordConfirm === null || typeof (this.userUpdateData.passwordConfirm) === 'undefined') {
            this.message.passwordConfirm = 'Trường không được để trống!'
            resultCheck = false
          } else if (this.userUpdateData.passwordConfirm !== this.userUpdateData.password) {
            this.message.passwordConfirm = 'Xác nhận mật khẩu không đúng!'
            resultCheck = false
          }
          else this.userUpdateData.isChangePass=true;
        }
        /*if (this.userUpdateData.password === '' || this.userUpdateData.password === null || typeof (this.userUpdateData.password) === 'undefined') {
          this.message.password = 'Trường không được để trống!'
          resultCheck = false
        }
        if (this.userUpdateData.passwordConfirm === '' || this.userUpdateData.passwordConfirm === null || typeof (this.userUpdateData.passwordConfirm) === 'undefined') {
          this.message.passwordConfirm = 'Trường không được để trống!'
          resultCheck = false
        } else if (this.userUpdateData.passwordConfirm !== this.userUpdateData.password) {
          this.message.passwordConfirm = 'Xác nhận mật khẩu không đúng!'
          resultCheck = false
        }*/
        return resultCheck
      }
    }
  }
</script>

<!--<style scoped>

</style>-->
