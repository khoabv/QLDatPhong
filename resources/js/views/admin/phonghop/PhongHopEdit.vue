<template>
  <div class="main-content add-users">
    <div class="page-header">
      <h3 class="page-title">Chỉnh sửa người dùng</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Quản lý phòng</a></li>
        <li class="breadcrumb-item active">Chỉnh sửa</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h6>Thông tin phòng</h6>
          </div>
          <div class="card-body">
            <form @submit.prevent="validateBeforeSubmit" class="form">
              <div :class="{'form-group' : true}">
                <label class="required">Tên phòng</label>
                <input
                  v-model.trim="updateData.ten_phong"
                  type="text"
                  class="form-control"
                  name="ten_phong"
                  placeholder="Nhập tên phòng"
                >
                <div class="message_invalid">
                  {{ message.ten_phong }}
                </div>
              </div>

              <!--<div :class="{'form-group' : true}">
                <label class="required">Mô tả</label>
                <input
                  v-model.trim="updateData.mo_ta"
                  type="text"
                  class="form-control"
                  name="mo_ta"
                  placeholder="Nhập mô tả"
                >
                <div class="message_invalid">
                  {{ message.mo_ta }}
                </div>
              </div>-->

              <div  class="form-group">
                <label class="">Mô tả</label>
                <textarea rows="3" class="form-control"
                          v-model="updateData.mo_ta"></textarea>
              </div>

              <div class="form-group">
                <select v-model = "updateData.trang_thai" class="custom-select">
                  <option value="0">Đang bảo trì</option>
                  <option value="1">Đang sử dụng</option>
                </select>
                <div class="invalid-feedback">
                  {{ message.trang_thai }}
                </div>
              </div>

              <div class="form-group">
                <select v-model = "updateData.loai_phong" class="custom-select">
                  <option value="">Loại phòng</option>
                  <option value="0">Hội thảo</option>
                  <option value="1">Phỏng vấn</option>
                  <option value="2">Họp</option>
                  <option value="3">Đào tạo</option>
                  <option value="4">Khác</option>
                </select>
                <div class="message_invalid">
                  {{ message.loai_phong }}
                </div>
              </div>
              <div class="form-group">
                <label class="required">Sức chứa</label>
                <input
                  v-model.trim="updateData.soluong"
                  type="number"
                  class="form-control"
                  name="mo_ta"
                  placeholder="Sức chứa"
                  min="1"
                >
                <div class="message_invalid">
                  {{ message.soluong }}
                </div>
              </div>

              <div class="form-group">
                <button class="btn btn-success">
                  Lưu
                </button>
                <router-link to="/admin/rooms/all">
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
  data () {
    return {
      updateData: {
        id: '',
        ten_phong: '',
        loai_phong:'',
        mo_ta: '',
        trang_thai: '',
        soluong:''
      },
      message: {
        ten_phong: '',
        trang_thai: '',
        loai_phong:'',
        soluong:'',
      }
    }
  },
  created: function () {
    this.getRoomById(this.$route.params.id)
  },
  methods: {
    async getRoomById (id) {
      try {
        // eslint-disable-next-line no-undef
        const response = await axios.get(`/api/admin/rooms/get/${id}`)
        this.updateData = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('Có lỗi xảy ra', 'Error')
        }
      }
    },
    async validateBeforeSubmit () {
      if (this.validate() === true) {
        // eslint-disable-next-line no-unused-vars,no-undef
        let response = await axios.post('/api/admin/rooms/update', this.updateData)
        if (response.data.result === true) {
          window.toastr['success'](response.data.message, 'Success')
          window.location.href = '/admin/rooms/all'
        } else window.toastr['error'](response.data.message, 'Error')
      }
    },
    validate () {
      this.message.ten_phong = ''
      this.message.loai_phong = ''
      this.message.trang_thai = ''
      let resultCheck = true
      if (this.updateData.ten_phong === '' || this.updateData.ten_phong === null || typeof (this.updateData.ten_phong) === 'undefined') {
        this.message.ten_phong = 'Trường không được để trống!'
        resultCheck = false
      }

      if (this.updateData.trang_thai === '' || this.updateData.trang_thai === null || typeof (this.updateData.trang_thai) === 'undefined') {
        this.message.trang_thai = 'Trường không được để trống!'
        resultCheck = false
      }
      if (this.updateData.loai_phong === '' || this.updateData.loai_phong === null || typeof (this.updateData.loai_phong) === 'undefined') {
        this.message.loai_phong = 'Trường không được để trống!'
        resultCheck = false
      }
      if (this.updateData.soluong === '' || this.updateData.soluong === null || typeof (this.updateData.soluong) === 'undefined') {
        this.message.soluong = 'Trường không được để trống!'
        resultCheck = false
      }
      return resultCheck
    }
  }
}
</script>

<!--<style scoped>

</style>-->
