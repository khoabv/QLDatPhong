<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Danh sách thông báo</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Quản lý thông báo</a></li>
        <li class="breadcrumb-item active">Danh sách</li>
      </ol>
      <div class="card">
        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-4"><label>Tiêu đề</label>
              <input type="text" placeholder="Nhập tiêu đề để tìm kiếm" class="form-control"
                     v-model="searchCondition.tieude">
            </div>
            <div class="form-group col-md-4"><label>Nội dung</label>
              <input type="text" placeholder="Nhập nội dung để tìm kiếm" class="form-control"
                     v-model="searchCondition.noidung">
            </div>
            <div class="form-group col-md-4"><label>Người nhận thông báo</label>
              <select v-model="searchCondition.userid" class="custom-select">
                <option value="">Tất cả</option>
                <option v-for="(item) in listnguoinhan" v-bind:value="item.id">{{item.email}}</option>

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
         <!-- <a class="btn btn-primary btn-pressable btn-fix" href="/admin/thongbao/add">Thêm mới</a>-->
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
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Tiêu đề</th>
                <th class="text-center">Nội dung</th>
                <th class="text-center">Tài khoản nhận</th>
                <th class="text-center">Thời gian gửi</th>
                <th class="text-center">Hoạt động</th>
              </tr>

              </thead>
              <tbody>
              <tr v-for="(item, index) in page.items">
                <td class="align-center">{{(page.pageNumber-1)*page.numberPerPage
                  + index+1}}
                </td>
                <td class="align-center">{{item.isRead==0?'Chưa xem':'Đã xem'}}</td>
                <td class="align-center">{{item.tieude}}</td>
                <td class="align-center">{{item.noidung}}</td>
                <td class="align-center">{{item.emailNguoiNhan}}</td>
                <td class="align-center">{{item.created_at}}</td>
                <td class="align-center">
                  <a :href="'/admin/thongbao/detail/' + item.id"><i class="icon-fa icon-fa-star"/>Chi tiết</a>
                  <!--<a :href="'/admin/thongbao/edit/' + item.id"><i class="icon-fa icon-fa-star"/>Chỉnh sửa</a>
                  <a
                    class="btn btn-default btn-sm"
                    data-delete
                    data-confirmation="notie"
                    @click="xoaThongBao(item.id)"
                  >
                    <i class="icon-fa icon-fa-trash"/> Xóa
                  </a>-->

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
          tieude: '',
          noidung: '',
          userid:''
        },
        listnguoinhan: []
      }
    },
    created: function () {
      this.loadPage(1)
      this.getListNguoiNhan();
    },
    methods: {
      async loadPage (page) {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/thongbao/get?page=${page}`)
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
          const response = await axios.get(`/api/admin/thongbao/get`, {
            params: {
              page: 1,
              tieude: this.searchCondition.tieude,
              noidung: this.searchCondition.noidung,
              userid: this.searchCondition.userid,
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
        this.searchCondition.tieude = ''
        this.searchCondition.noidung = ''
        this.searchCondition.userid = ''
      },
      xoaThongBao (id) {
        let self = this
        window.notie.confirm({
          text: 'Bạn chắc chắn muốn xóa?',
          cancelCallback: function () {
            window.toastr['info']('Hủy')
          },
          submitCallback: function () {
            self.xoaDuLieuThongBao(id)
          }
        })
      },
       async xoaDuLieuThongBao (id) {
        try {
          let response = await window.axios.delete('/api/admin/thongbao/' + id)
          this.page = response.data
          window.toastr['success']('Xóa thông báo thành công', 'Success')
          window.location.href = '/admin/thongbao/all'
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async getListNguoiNhan () {
        const dsnguoinhan = await axios.get('/api/admin/users/danhsachnguoidung')
        this.listnguoinhan = dsnguoinhan.data.nguoidat
        console.log(this.listnguoidnhan)
      },
    }
  }
</script>
