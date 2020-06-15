<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Danh sách phòng họp</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Quản lý phòng</a></li>
        <li class="breadcrumb-item active">Danh sách</li>
      </ol>
      <div class="card form">
        <div class="row">
          <div class="form-row col-md-12 margin">

            <div class="form-group col-md-4">
              <label>Loại phòng</label>
              <select v-model="searchCondition.loaiPhong"  class="custom-select .ls-select2">
                <option value="">Tất cả</option>
                <option value="0">Hội thảo</option>
                <option value="1">Phỏng vấn</option>
                <option value="2">Họp</option>
                <option value="3">Đào tạo</option>
                <option value="4">Khác</option>
              </select>
            </div>

            <div class="form-group col-md-4">
              <label>Tên phòng</label>
              <input type="text" id="inputFirstName" placeholder="Nhập tên phòng để tìm kiếm" class="form-control"
                     v-model="searchCondition.ten_phong">
            </div>
            <div class="form-group col-md-4"><label>Trạng thái phòng</label>
              <select v-model="searchCondition.trang_thai" class="custom-select">
                <option value="">Tất cả trạng thái</option>
                <option value="0">Đang bảo trì</option>
                <option value="1">Đang sử dụng</option>
              </select>
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
          <a class="btn btn-primary btn-pressable btn-fix" href="/admin/rooms/add">Thêm mới</a>
        </div>
        <div class="line line-lg"></div>

      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h6>Danh sách</h6>
            <div class="card-actions"/>
          </div>
          <div class="card-body">
            <table class="table table-striped table-bordered m-b-none text-sm">
              <thead>
              <tr>
                <th class="text-center">STT</th>
                <th class="text-center">Tên phòng họp</th>
                <th class="text-center">Mô tả</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Loại phòng</th>
                <th class="text-center">Số lượng</th>
                <th class="text-center">Hoạt động</th>
              </tr>

              </thead>
              <tbody>
              <tr v-for="(item, index) in page.items">
                <td class="align-center">{{(page.pageNumber-1)*page.numberPerPage
                  + index+1}}
                </td>
                <td class="align-center">{{item.ten_phong}}</td>
                <td class="align-center">{{item.mo_ta}}</td>
                <td class="align-center">{{item.trang_thai===0?'Đang bảo trì':'Đang sử dụng'}}</td>
                <td class="align-center">{{item.loai_phong===0?'Hội thảo':item.loai_phong===1?'Phỏng vấn':item.loai_phong===2?"Họp":item.loai_phong===3?"Đào tạo":"Khác"}}</td>
                <td class="align-center">{{item.soluong}}</td>

                <td class="align-center">
                  <a :href="'/admin/rooms/edit/' + item.id"><i class="icon-fa icon-fa-star"/>Chỉnh sửa</a>
                  <a
                    class="btn btn-default btn-sm"
                    data-delete
                    data-confirmation="notie"
                    @click="xoaPhongHop(item.id)"
                  >
                    <i class="icon-fa icon-fa-trash"/> Xóa
                  </a>
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
      </div>
    </div>

  </div>


</template>

<script type="text/babel">



  import {TableComponent, TableColumn} from 'vue-table-component'
  import CommonJs from '../../../common'
  export default {
    components: {
      TableComponent,
      TableColumn,
    },
    data () {
      return {
        page: CommonJs.page,
        searchCondition: {
          ten_phong: '',
          loaiPhong:'',
          trang_thai: '',
          batdau:'',
          ketthuc:''

        }
      }
    },
    created: function () {
      this.loadPage(1)
    },
    methods: {
      async loadPage (page) {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/rooms/get`,{
            params:{
              page: page,
              ten_phong: this.searchCondition.ten_phong,
              trang_thai: this.searchCondition.trang_thai,
              loaiPhong: this.searchCondition.loaiPhong
            }})
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
          const response = await axios.get(`/api/admin/rooms/get`, {
            params: {
              page: 1,
              ten_phong: this.searchCondition.ten_phong,
              trang_thai: this.searchCondition.trang_thai,
              loaiPhong: this.searchCondition.loaiPhong
            }
          })
          this.page = response.data
          this.page.pageCount = CommonJs.getPageCount(this.page);
          this.page.pageList = CommonJs.getPageList(this.page)
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      clearCondition () {
        this.searchCondition.ten_phong = ''
        this.searchCondition.trang_thai = ''
        this.searchCondition.loaiPhong = ''
      },
      xoaPhongHop (id) {
        let self = this
        window.notie.confirm({
          text: 'Bạn chắc chắn muốn xóa?',
          cancelCallback: function () {
            window.toastr['info']('Hủy')
          },
          submitCallback: function () {
            self.xoaDuLieuPhongHop(id)
          }
        })
      },
      async xoaDuLieuPhongHop (id) {
        try {
          let response = await window.axios.delete('/api/admin/rooms/' + id)
          this.page = response.data
          window.toastr['success']('Xóa phòng họp thành công', 'Success')
          window.location.href = '/admin/rooms/all'
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      }
    }
  }
</script>
