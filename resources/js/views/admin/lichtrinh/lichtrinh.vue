<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Danh sách lịch trình đặt phòng</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Quản lịch trình</a></li>
        <li class="breadcrumb-item active">Danh sách</li>
      </ol>

    </div>
    <div class="card form">
      <div class="row">
        <div class="form-row col-md-12 margin">
          <div class="form-group col-md-2">
            <label>Mã lịch trình</label>
          </div>
          <div class="form-group col-md-3">
            <input type="text" v-model="searchCondition.malichtrinh" class="form-control col-md-12">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="form-row col-md-12 margin">
          <div class="form-group col-md-2">
            <label>Tên phòng</label>
          </div>

          <div class="form-group col-md-3">
            <select v-model="searchCondition.idPhongHop" class="custom-select .ls-select2">
              <option value="">Tất cả phòng họp</option>
              <option v-for="(item) in listphong" v-bind:value="item.id">{{item.ten_phong}}</option>

            </select>
          </div>
          <div class="form-group col-md-2">
            <label>Người đặt</label>
          </div>
          <div class="form-group col-md-3">
            <select v-model="searchCondition.idNguoiDat" class="custom-select">
              <option value="">Tất cả</option>
              <option v-for="(item) in listnguoidat" v-bind:value="item.id">{{item.email}}</option>

            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-row col-md-12 margin">
          <div class="form-group col-md-2">
            <label>Thời gian từ</label>
          </div>
          <div class="form-group col-md-3">
            <!--<datetime format="H:i" v-model="searchCondition.batdau"></datetime>-->
            <Select2 v-model="searchCondition.batdau" :options="listTime"/>
          </div>
          <div class="form-group col-md-2">
            <label>đến</label>
          </div>
          <div class="form-group col-md-3">
            <!--<datetime format="H:i" v-model="searchCondition.ketthuc"></datetime>-->
            <Select2 v-model="searchCondition.ketthuc" :options="listTime"/>

            <!-- <input type="password" id="inputLastName" placeholder="Last Name"class="form-control">-->
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-row col-md-12 margin">
          <div class="form-group col-md-2">
            <label>Ngày đặt</label>
          </div>
          <div class="form-group col-md-3">
            <datetime format="DD/MM/YYYY" v-model="searchCondition.ngaydatphong"></datetime>

            <!-- <input type="password" id="inputLastName" placeholder="Last Name"class="form-control">-->
          </div>
        </div>
      </div>
      <div class="form-row center">
        <button type="button" class="btn btn-secondary btn-pressable btn-fix" @click="clearCondition()">Xóa điều
          kiện
        </button>
        <button type="button" class="btn btn-info btn-pressable btn-fix" @click="search()">Tìm
          kiếm
        </button>
        <a class="btn btn-primary btn-pressable btn-fix" href="/admin/lichtrinh/add">Thêm mới</a>
      </div>
      <div class="line line-lg"></div>

    </div>
    <div class="card-body">
      <table class="table table-striped table-bordered m-b-none text-sm">
        <thead>
        <tr>
          <th class="text-center">STT</th>
          <th class="text-center">Mã lịch trình</th>
          <th class="text-center">Tên phòng họp</th>
          <th class="text-center">Loại phòng</th>
          <th class="text-center">Vào Thứ</th>
          <th class="text-center">Thời gian đặt</th>
          <th class="text-center">Khung giờ</th>
          <th class="text-center">Định kì</th>
          <th class="text-center">Người đặt</th>
          <th class="text-center">Trạng thái</th>
          <th class="text-center">Hoạt động</th>

        </tr>

        </thead>
        <tbody>
        <tr v-for="(item, index) in page.items">
          <td class="align-center">{{(page.pageNumber-1)*page.numberPerPage
            + index+1}}
          </td>
          <td class="align-center">{{item.malichtrinh}}</td>
          <td class="align-center">{{item.tenPhongHop}}</td>
          <td class="align-center">
            {{item.loaiPhongHop===0?'Hội thảo':item.loaiPhongHop===1?'Phỏng vấn':item.loaiPhongHop===2?'Họp':item.loaiPhongHop===3?'Đào tạo':'Khác'}}
          </td>
          <td class="align-center">{{item.thu}}</td>
          <td class="align-center">{{item.loailichtrinh===0 ? item.ngaybatdau : item.ngaybatdau +' -> '+
            item.ngayketthuc}}
          </td>
          <td class="align-center">{{item.thoigianbatdau}} - {{item.thoigianketthuc}}</td>
          <td class="align-center">{{item.loailichtrinh===0?'Không':'Có'}}</td>
          <td class="align-center">{{item.tenNguoiDat}}<br>
          ({{item.emailNguoiDat}})</td>
          <td class="align-center">
            {{item.trangthai===0?'Đã duyệt':item.trangthai===1?'Chờ duyệt':item.trangthai===2?'Từ chối':'Khác'}}
          </td>

          <td class="align-center">

            <div class="btn-group" role="group">
              <v-dropdown :show-arrow="false" theme-light>
                <button
                  slot="activator"
                  type="button"
                  class="btn btn-outline-default dropdown-toggle"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  Lựa chọn
                </button>
                <v-dropdown-item>
                  <a :href="'/admin/lichtrinh/edit/' + item.id" class="dropdown-item">
                    <img class="icon_action_in_list" src="/assets/img/edit.png" title="Chỉnh sửa">
                    Chỉnh sửa</a>
                </v-dropdown-item>
                <v-dropdown-item>
                  <a href="javascript:void(0)" class="dropdown-item" data-delete data-confirmation="notie"
                     @click="xoaLichTrinh(item.id)">
                    <img class="icon_action_in_list" src="/assets/img/delete.png" title="Xóa">
                    Xóa
                  </a>
                </v-dropdown-item>
                <v-dropdown-item v-if="item.trangthai!==0">
                  <a href="javascript:void(0)" class="dropdown-item" data-delete data-confirmation="notie"
                     @click="pheDuyetDatPhong(item.id)">
                    <img class="icon_action_in_list" src="/assets/img/approve.png" title="Phê duyệt đặt phòng">
                    Phê duyệt
                  </a>
                </v-dropdown-item>
                <v-dropdown-item v-if="item.trangthai!==2">
                  <a href="javascript:void(0)" class="dropdown-item" data-delete data-confirmation="notie"
                     @click="huyDatPhong(item.id)">
                    <img class="icon_action_in_list" src="/assets/img/reject.png" title="Hủy đặt phòng">
                    Hủy đặt phòng
                  </a>
                </v-dropdown-item>
                <v-dropdown-item>
                  <a :href="'/admin/lichtrinh/chuyennhuong/' + item.id" class="dropdown-item">
                    <img class="icon_action_in_list" src="/assets/img/move.png" title="Chuyển nhượng phòng">
                    Chuyển nhượng
                  </a>
                </v-dropdown-item>
              </v-dropdown>
            </div>
          </td>

        </tr>

        </tbody>
      </table>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" id="users-datatable_info" role="status" aria-live="polite">Tổng số <code>{{page.rowCount}}</code>
              dữ liệu
            </div>
          </div>
          <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers" id="users-datatable_paginate">
              <ul class="pagination">
                <li v-if="page.pageNumber>1"><a href="javascript:void(0)"
                                                @click="loadPage(1)">«</a></li>
                <li v-for="pageNum in page.pageList">
                  <a href="javascript:void(0)" v-if="pageNum==page.pageNumber"
                     style="color:mediumvioletred;"> {{pageNum}}</a>
                  <a href="javascript:void(0)" v-if="pageNum!=page.pageNumber"
                     @click="loadPage(pageNum)"> {{pageNum}}</a>
                </li>
                <li v-if="page.pageNumber<page.pageCount"><a href="javascript:void(0)"
                                                             @click="loadPage(page.pageCount)">»</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>

    </div>

  </div>


</template>

<script type="text/babel">
  import $ from 'jquery'

  import datetime from 'vuejs-datetimepicker'
  import CommonJs from '../../../common'
  import Constants from '../../../Constants'
  import Select2 from 'v-select2-component';

  // import Select2Component
 /* import Select2 from 'v-select2-component';*/

  export default {
    /* name: 'UsersAdd', */
    components: {
      'Select2': Select2,
      datetime
    },
    data () {
      return {
        page: CommonJs.page,
        listTime:Constants.listTime,
        searchCondition: {
          batdau: '',
          ketthuc: '',
          idPhongHop: '',
          ngaydatphong: '',
          idNguoiDat: '',
          thu: []
        },
        listphong: [],
        listnguoidat: [],
        lichtrinhPheDuyet:{
          id:"",
          trangthai:""
        }
      }
    },
    created: function () {
      this.loadPage(1)
      this.loadphong()
    },

    methods: {
      async loadPage (page) {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/lichtrinh/get`,{
            params: {
              page: page,
              malichtrinh: this.searchCondition.malichtrinh,
              idPhongHop: this.searchCondition.idPhongHop,
              batdau: this.searchCondition.batdau,
              ketthuc: this.searchCondition.ketthuc,
              ngaydatphong: this.searchCondition.ngaydatphong,
              idNguoiDat: this.searchCondition.idNguoiDat,
              thu: this.searchCondition.thu
            }
          })
          this.page = response.data
          this.page.pageCount = CommonJs.getPageCount(this.page)
          this.page.pageList = CommonJs.getPageList(this.page)
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async loadPage () {
        try {
          // eslint-disable-next-line no-undef
          console.log('current page = '+this.page.pageNumber)
          const response = await axios.get(`/api/admin/lichtrinh/get`,{
            params: {
              page: this.page.pageNumber,
              malichtrinh: this.searchCondition.malichtrinh,
              idPhongHop: this.searchCondition.idPhongHop,
              batdau: this.searchCondition.batdau,
              ketthuc: this.searchCondition.ketthuc,
              ngaydatphong: this.searchCondition.ngaydatphong,
              idNguoiDat: this.searchCondition.idNguoiDat,
              thu: this.searchCondition.thu
            }
          })
          this.page = response.data
          this.page.pageCount = CommonJs.getPageCount(this.page)
          this.page.pageList = CommonJs.getPageList(this.page)
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async search () {
        console.log('gọi đến hàm search')
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/lichtrinh/get`, {
            params: {
              page: 1,
              malichtrinh: this.searchCondition.malichtrinh,
              idPhongHop: this.searchCondition.idPhongHop,
              batdau: this.searchCondition.batdau,
              ketthuc: this.searchCondition.ketthuc,
              ngaydatphong: this.searchCondition.ngaydatphong,
              idNguoiDat: this.searchCondition.idNguoiDat,
              thu: this.searchCondition.thu
            }
          })
          this.page = response.data
          this.page.pageCount = CommonJs.getPageCount(this.page)
          this.page.pageList = CommonJs.getPageList(this.page)
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      clearCondition () {
        this.searchCondition.malichtrinh = ''
        this.searchCondition.batdau = ''
        this.searchCondition.ketthuc = ''
        this.searchCondition.idPhongHop = ''
        this.searchCondition.ngaydatphong = ''
        this.searchCondition.idNguoiDat = ''
        this.searchCondition.thu = []
      },
      async loadphong () {
        const response = await axios.get(`/api/admin/rooms/danhsachphong`)
        this.listphong = response.data.listphong
        console.log(this.listphong)

        const dsnguoidat = await axios.get('/api/admin/users/danhsachnguoidung')
        this.listnguoidat = dsnguoidat.data.nguoidat
        console.log(this.listnguoidat)
        console.log(this.listphong)
      },
      xoaLichTrinh (id) {
        let self = this
        window.notie.confirm({
          text: 'Bạn chắc chắn muốn xóa?',
          cancelCallback: function () {
            window.toastr['info']('Hủy')
          },
          submitCallback: function () {
            self.xoaDuLieuLichTrinh(id)
          }
        })
      },
      async xoaDuLieuLichTrinh (id) {
        try {
          let response = await window.axios.delete('/api/admin/lichtrinh/' + id)
          this.page = response.data
          window.toastr['success']('Xóa lịch trình thành công', 'Success')
          window.location.href = '/admin/lichtrinh/all'
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      pheDuyetDatPhong (id) {
        this.lichtrinhPheDuyet.trangthai = 0
        this.lichtrinhPheDuyet.id = id
        let self = this
        window.notie.confirm({
          text: 'Bạn chắc chắn muốn phê duyệt đặt phòng này?',
          cancelCallback: function () {
            window.toastr['info']('Hủy')
          },
          submitCallback: function () {
            self.duyetPhong()
          }
        })
      },
      huyDatPhong (id) {
        this.lichtrinhPheDuyet.trangthai = 2
        this.lichtrinhPheDuyet.id = id
        let self = this
        window.notie.confirm({
          text: 'Bạn chắc chắn muốn hủy đặt phòng này?',
          cancelCallback: function () {
            window.toastr['info']('Hủy')
          },
          submitCallback: function () {
            self.duyetPhong()
          }
        })
      },
      async duyetPhong () {
        try {
          let response = await axios.post('/api/admin/lichtrinh/duyetPhong', this.lichtrinhPheDuyet)
          this.page = response.data
          window.toastr['success'](response.data.message, 'Success')
          let currentPage = this.page.pageNumber
          this.search()
          // window.location.href = '/admin/lichtrinh/all'
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      }

    }
  }


</script>
