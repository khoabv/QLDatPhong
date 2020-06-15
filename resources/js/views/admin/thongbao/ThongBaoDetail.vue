<template>
  <div class="main-content add-users">
    <div class="page-header">
      <h3 class="page-title">Chi tiết thông báo</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Quản lý thông báo</a></li>
        <li class="breadcrumb-item active">Chi tiết</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h6>Thông tin thông báo</h6>
          </div>
          <div class="card-body">
            <form>
              <div class="form-group row"><label class="col-sm-2 form-control-label bold">Tiêu đề</label>
                <div class="col-sm-10"><p class="form-control-plaintext">{{dataDetail.tieude}}</p></div>
              </div>
              <div class="form-group row"><label class="col-sm-2 form-control-label bold">Nội dung</label>
                <div class="col-sm-10"><p class="form-control-plaintext">{{dataDetail.noidung}}</p></div>
              </div>
              <div class="form-group row"><label class="col-sm-2 form-control-label bold">Email người nhận</label>
                <div class="col-sm-10"><p class="form-control-plaintext">{{dataDetail.emailNguoiNhan}}</p></div>
              </div>
              <div class="form-group row"><label class="col-sm-2 form-control-label bold">Thời gian gửi thông báo</label>
                <div class="col-sm-10"><p class="form-control-plaintext">{{dataDetail.created_at}}</p></div>
              </div>
              <div class="form-group">
                <router-link to="/thongbao/all">
                  <a class="btn btn-secondary">
                    Quay lại danh sách
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
        dataDetail: {
          id: '',
          tieude: '',
          noidung: '',
          userid: '',
          emailNguoiNhan: '',
          created_at: ''
        }
      }
    },
    created: function () {
      this.getThongBaoId(this.$route.params.id)
    },
    methods: {
      async getThongBaoId (id) {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/thongbao/get/${id}`)
          this.dataDetail = response.data.thongbao
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
    }
  }
</script>

<!--<style scoped>

</style>-->
