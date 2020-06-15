<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Danh sách cuộc họp</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item active">Cuộc họp Quản lý cuộc họp</li>
        <li class="breadcrumb-item active">Danh sách</li>
      </ol>

    </div>
    <div class="card form">
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
            <label>Tên cuộc họp</label>
          </div>
          <div class="form-group col-md-3">
            <input type="text" id="inputFirstName" placeholder="Nhập tên cuộc họp để tìm kiếm" class="form-control"
                   v-model="searchCondition.tencuochop">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-row col-md-12 margin">
          <div class="form-group col-md-2">
            <label>Thời gian từ</label>
          </div>
          <div class="form-group col-md-3">
          <!--  <datetime format="H:i" v-model="searchCondition.batdau"></datetime>-->
            <Select2 v-model="searchCondition.batdau" :options="listTime"/>
          </div>
          <div class="form-group col-md-2">
            <label>đến</label>
          </div>
          <div class="form-group col-md-3">
            <!--<datetime format="H:i" v-model="searchCondition.ketthuc"></datetime>-->
            <Select2 v-model="searchCondition.ketthuc" :options="listTime"/>
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
        <!--<a class="btn btn-primary btn-pressable btn-fix" href="/cuochop/add">Thêm mới</a>-->
      </div>
      <div class="line line-lg"></div>

    </div>
    <div class="card-body">
      <table class="table table-striped table-bordered m-b-none text-sm">
        <thead>
        <tr>
          <th class="text-center">STT</th>
          <th class="text-center">Tên phòng họp</th>
          <th class="text-center">Tên cuộc họp</th>
          <th class="text-center">Vào Thứ</th>
          <th class="text-center">Thời gian (ngày)</th>
          <th class="text-center">Khung giờ</th>
          <th class="text-center">Định kì</th>
          <th class="text-center">Trạng thái</th>
          <th class="text-center">Hoạt động</th>

        </tr>

        </thead>
        <tbody>
        <tr v-for="(item, index) in page.items">
          <td class="align-center">{{(page.pageNumber-1)*page.numberPerPage
            + index+1}}
          </td>
          <td class="align-center">{{item.tenPhongHop}}</td>
          <td class="align-center">
            {{item.tencuochop}}
          </td>
          <td class="align-center">{{item.thu}}</td>
          <td class="align-center">{{item.loailichtrinh===0 ? item.ngaybatdau : item.ngaybatdau +' -> '+
            item.ngayketthuc}}
          </td>
          <td class="align-center">{{item.thoigianbatdau}} - {{item.thoigianketthuc}}</td>
          <td class="align-center">{{item.loailichtrinh===0?'Không':'Có'}}</td>
          <td class="align-center">
            {{item.trangthai===0?'Chưa hoàn thành':item.trangthai===1?'Đã hoàn thành':'Khác'}}
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
                  <a :href="'/admin/cuochop/detail/' + item.id" class="dropdown-item">
                    <img class="icon_action_in_list" src="/assets/img/detail.png" title="Chi tiết">
                    Chi tiết cuộc họp</a>
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
      datetime},
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
        },
        userLoggedOn:{}
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
          const response = await axios.get(`/api/admin/cuochop/get`, {
            params: {
              page: page,
              idPhongHop: this.searchCondition.idPhongHop,
              batdau: this.searchCondition.batdau,
              ketthuc: this.searchCondition.ketthuc,
              ngaydatphong: this.searchCondition.ngaydatphong,
              thu: this.searchCondition.thu
            }}
          )
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
          const response = await axios.get(`/api/admin/cuochop/get`, {
            params: {
              page: 1,
              idPhongHop: this.searchCondition.idPhongHop,
              batdau: this.searchCondition.batdau,
              ketthuc: this.searchCondition.ketthuc,
              ngaydatphong: this.searchCondition.ngaydatphong,
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
        this.searchCondition.batdau = ''
        this.searchCondition.ketthuc = ''
        this.searchCondition.idPhongHop = ''
        this.searchCondition.ngaydatphong = ''
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
      xoaCuocHop(id) {
        let self = this
        window.notie.confirm({
          text: 'Bạn chắc chắn muốn xóa?',
          cancelCallback: function () {
            window.toastr['info']('Hủy')
          },
          submitCallback: function () {
            self.xoaDuLieuCuocHop(id)
          }
        })
      },
      async xoaDuLieuCuocHop (id) {
        try {
          let response = await window.axios.delete('/api/admin/cuochop/' + id)
          this.page = response.data
          window.toastr['success']('Xóa cuộc họp thành công', 'Success')
          window.location.href = '/cuochop/all'
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      }

    }
  }


</script>
