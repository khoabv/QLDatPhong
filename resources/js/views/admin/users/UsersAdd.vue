<template>
  <div class="main-content add-users">
    <div class="page-header">
      <h3 class="page-title">Thêm mới người dùng</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Quản lý người dùng</a></li>
        <li class="breadcrumb-item active">Thêm mới</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h6>Thông tin người dùng</h6>
          </div>
          <div class="card-body">
            <form @submit.prevent="validateBeforeSubmit">
              <div :class="{'form-group' : true}">
                <label class="required">Họ tên</label>
                <input
                  v-model.trim="userAddData.name"
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
                  v-model.trim="userAddData.email"
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
                <label class="required">Mật khẩu</label>
                <input
                  v-model.trim="userAddData.password"
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
                <label class="required">Xác nhận mật khẩu</label>
                <input
                  v-model.trim="userAddData.passwordConfirm"
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
                <select v-model = "userAddData.role" class="custom-select">
                  <option value="user">Người dùng</option>
                  <option value="admin">Quản trị</option>
                </select>
                <div class="message_invalid">
                  {{ message.role }}
                </div>
              </div>

              <div class="form-group">
                <label class="required">Trạng thái</label>
                <select v-model = "userAddData.isActive" class="custom-select">
                  <option value="1">Kích hoạt</option>
                  <option value="0">Tạm khóa</option>
                </select>
              </div>

              <div class="form-group">
                <button class="btn btn-success">
                  Lưu
                </button>
                <router-link to="/admin/users/all">
                  <a class="btn btn-secondary">
                    Hủy
                  </a>
                </router-link>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  /* name: 'UsersAdd', */
  data () {
    return {
      userAddData: {
        name: '',
        email: '',
        password: '',
        passwordConfirm: '',
        role: 'user',
        isActive:1
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
  methods: {
    async validateBeforeSubmit () {
      if (this.validate()) {
        // eslint-disable-next-line no-unused-vars,no-undef
        let response = await axios.post('/api/admin/users/create', this.userAddData)
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
      let resultCheck = true;
      if (this.userAddData.name === '' || this.userAddData.name === null || typeof (this.userAddData.name) === 'undefined') {
        this.message.name = 'Trường không được để trống!'
        resultCheck = false
      }
      if (this.userAddData.email === '' || this.userAddData.email === null || typeof (this.userAddData.email) === 'undefined') {
        this.message.email = 'Trường không được để trống!'
        resultCheck = false
      }
      if (this.userAddData.role === '' || this.userAddData.role === null || typeof (this.userAddData.role) === 'undefined') {
        this.message.role = 'Trường không được để trống!'
        resultCheck = false
      }
      if (this.userAddData.password === '' || this.userAddData.password === null || typeof (this.userAddData.password) === 'undefined') {
        this.message.password = 'Trường không được để trống!'
        resultCheck = false
      }
      if (this.userAddData.passwordConfirm === '' || this.userAddData.passwordConfirm === null || typeof (this.userAddData.passwordConfirm) === 'undefined') {
        this.message.passwordConfirm = 'Trường không được để trống!'
        resultCheck = false
      } else if (this.userAddData.passwordConfirm !== this.userAddData.password) {
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
