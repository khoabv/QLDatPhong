<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Đặt phòng</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Đặt phòng</a></li>
      </ol>

    </div>
    <div class="card">
      <div class="form">
        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Loại phòng</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="searchRoom.loaiPhong"  class="custom-select .ls-select2" @change="loadphong()">
                <option value="">Tất cả</option>
                <option value="0">Hội thảo</option>
                <option value="1">Phỏng vấn</option>
                <option value="2">Họp</option>
                <option value="3">Đào tạo</option>
                <option value="4">Khác</option>
              </select>
            </div>

            <div class="form-group col-md-2">
              <label>Tên phòng</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="searchRoom.idPhongHop"  class="custom-select .ls-select2">
                <option value="">Tất cả phòng họp</option>
                <option v-for="(item) in listphong" v-bind:value="item.id">{{item.ten_phong}}</option>

              </select>
            </div>

          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Số lượng ghế</label>
            </div>
            <div class="form-group col-md-3">
              <input
                v-model.trim="searchRoom.soluong"
                type="text"
                class="form-control"
                placeholder="Nhập số lượng ghế"
              >
            </div>

          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label class="required">Thời gian từ</label>
            </div>
            <!--<div class="form-group col-md-3">
              <datetime format="H:i" v-model="searchRoom.batdau"></datetime>
            </div>-->
            <div class="form-group col-md-3">
              <Select2 v-model="searchRoom.batdau" :options="listTime"/>
              <div class="message_invalid">
                {{ message.batdau }}
              </div>
            </div>
            <div class="form-group col-md-2">
              <label class="required">đến</label>
            </div>
            <div class="form-group col-md-3">
              <!--<datetime format="H:i" v-model="searchRoom.ketthuc"></datetime>-->
              <Select2 v-model="searchRoom.ketthuc" :options="listTime"/>
              <div class="message_invalid">
                {{ message.ketthuc }}
              </div>
              <!-- <input type="password" id="inputLastName" placeholder="Last Name"class="form-control">-->
            </div>
          </div>
        </div>

        <div class="row" v-if="searchRoom.isDinhki==false">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label class="required">Ngày đặt</label>
            </div>
            <div class="form-group col-md-3">
              <datetime format="YYYY-MM-DD" v-model="searchRoom.ngaydatphong"></datetime>
              <div class="message_invalid">
                {{ message.ngaydatphong }}
              </div>
              <!-- <input type="password" id="inputLastName" placeholder="Last Name"class="form-control">-->
            </div>
          </div>
        </div>

        <div class="row" v-if="searchRoom.isDinhki==true">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label class="required">Thời gian từ ngày</label>
            </div>
            <div class="form-group col-md-3">
              <datetime format="YYYY-MM-DD" v-model="searchRoom.tungay"></datetime>
              <div class="message_invalid">
                {{ message.tungay }}
              </div>
            </div>
            <div class="form-group col-md-2">
              <label class="required">đến ngày</label>
            </div>
            <div class="form-group col-md-3">
              <datetime format="YYYY-MM-DD" v-model="searchRoom.denngay"></datetime>
              <div class="message_invalid">
                {{ message.denngay }}
              </div>
            </div>
          </div>
        </div>

        <div class="row" v-if="searchRoom.isDinhki==true">
          <div class="form-row col-md-12 margin">

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="2" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="searchRoom.thu">Thứ 2
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="3" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="searchRoom.thu">Thứ 3
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="4" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="searchRoom.thu">Thứ 4
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="5" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="searchRoom.thu">Thứ 5
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="6" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="searchRoom.thu">Thứ 6
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="7" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="searchRoom.thu">Thứ 7
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="CN" placeholder=""
                     v-model="searchRoom.thu">Chủ nhật
            </div>

          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">

            <div class="form-group col-md-3">
              <input type="checkbox" name="isdinhki" v-on:change="isdinhki()" placeholder=""
                     v-model="searchRoom.isDinhki">Định kì
            </div>
          </div>
        </div>

        <div class="form-row center">

          <button class="btn btn-success" @click="search()">
            Tìm kiếm
          </button>

        </div>
        <div class="line line-lg"></div>
      </div>
    </div>


    <div class="card">
      <div class="card-header">
        <h6>Danh sách phòng thỏa mãn</h6>
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
            <th class="text-center">Số lượng ghế</th>
            <th class="text-center">Hoạt động</th>
          </tr>

          </thead>
          <tbody>
          <tr v-for="(item, index) in page.items">
            <td class="align-center">{{(page.pageNumber-1)*page.numberPerPage
              + index+1}}
            </td>
            <td class="align-center">{{item.tenPhongHop}}</td>
            <td class="align-center">{{item.moTaPhongHop}}</td>
            <td class="align-center">{{item.trang_thai===0?'Đang bảo trì':'Đang sử dụng'}}</td>
            <td class="align-center">{{item.loaiPhongHop===0?'Hội thảo':item.loaiPhongHop===1?'Phỏng vấn':item.loaiPhongHop===2?"Họp":item.loaiPhongHop===3?"Đào tạo":"Khác"}}</td>
            <td class="align-center">{{item.soLuongGhe}}</td>

            <td class="align-center">
              <a :href="'/rooms/detail/' + item.id+'?batdau='+searchRoom.batdau+
              '&ketthuc='+searchRoom.ketthuc+'&tungay='+searchRoom.tungay+
              '&ngaydatphong='+searchRoom.ngaydatphong+
              '&denngay='+searchRoom.denngay+'&isDinhki2='+searchRoom.isDinhki+
              '&thu='+searchRoom.thu"><i class="icon-fa icon-fa-star"/>Chi tiết phòng</a>
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

    <div class="card" v-if="showLichTrinhThoaManDaDat==true">
      <div class="card-header">
        <h6>Danh sách lịch trình đã được đặt và đang trong trạng thái chờ sử dụng, bạn có thể gửi yêu cầu nhượng lại phòng</h6>
        <div class="card-actions"/>
      </div>
      <div class="card-body" >
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
          <tr v-for="(item, index) in pageLichTrinhThoaManDaDat.items">
            <td class="align-center">{{(pageLichTrinhThoaManDaDat.pageNumber-1)*pageLichTrinhThoaManDaDat.numberPerPage
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
              Chờ sử dụng
              <!--{{item.trangthai===0?'Đã duyệt':item.trangthai===1?'Chờ duyệt':item.trangthai===2?'Từ chối':'Khác'}}-->
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
                    <a :href="'/lichtrinh/detail/' + item.id" class="dropdown-item">
                      <img class="icon_action_in_list" src="/assets/img/edit.png" title="Chi tiết">
                      Chi tiết</a>
                  </v-dropdown-item>
                  <v-dropdown-item>
                    <a :href="'/lichtrinh/yeucaunhuongphong/' + item.id" class="dropdown-item">
                      <img class="icon_action_in_list" src="/assets/img/move.png" title="Yêu cầu nhượng phòng">
                      Yêu cầu nhượng phòng
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
              <div class="dataTables_info"  role="status" aria-live="polite">Tổng số <code>{{pageLichTrinhThoaManDaDat.rowCount}}</code>
                dữ liệu
              </div>
            </div>
            <div class="col-sm-12 col-md-7">
              <div class="dataTables_paginate paging_simple_numbers" >
                <ul class="pagination">
                  <li v-if="pageLichTrinhThoaManDaDat.pageNumber > 1"><a href="javascript:void(0)"
                                                  @click="loadPage(1)">«</a></li>
                  <li v-for="pageNum in pageLichTrinhThoaManDaDat.pageList">
                    <a href="javascript:void(0)" v-if="pageNum==page.pageNumber"
                       style="color:mediumvioletred;"> {{pageNum}}</a>
                    <a href="javascript:void(0)" v-if="pageNum!=page.pageNumber"
                       @click="loadPage(pageNum)"> {{pageNum}}</a>
                  </li>
                  <li v-if="pageLichTrinhThoaManDaDat.pageNumber<pageLichTrinhThoaManDaDat.pageCount"><a href="javascript:void(0)"
                                                               @click="loadPageLichTrinhDaDat(pageLichTrinhThoaManDaDat.pageCount)">»</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>

      </div>
    </div>


  </div>


</template>

<script type="text/babel">

  import datetime from 'vuejs-datetimepicker';
  import CommonJs from '../../../common'
  import Constants from '../../../Constants'
  import {TableComponent, TableColumn} from 'vue-table-component'
  // import Select2Component
  import Select2 from 'v-select2-component';

  export default {
    /* name: 'UsersAdd', */
    components: {
      /*"vue-select": require("vue-select"),*/
      'Select2': Select2,
      datetime
    },
    data() {
      return {
        myOptions: [{id:1, key:'op1'}, {id:2, key:'op2'}, {id:3, key:'op3'}], // or [{id: key, text: value}, {id: key, text: value}]
        page: CommonJs.page,
        pageLichTrinhThoaManDaDat: CommonJs.page,
        showLichTrinhThoaManDaDat: false,
        listTime:Constants.listTime,
        searchRoom: {
          idPhongHop:'',
          loaiPhong:'',
          batdau: '',
          ketthuc: '',
          ngaydatphong: '',
          thu: [],
          tungay: '',
          denngay: '',
          isDinhki: false,
          soluong:''

        },
        phonghopSelected:{},
        message: {
          tungay: '',
          denngay: '',
          batdau: '',
          ketthuc: '',
          ngaydatphong:''
        },
        listphong: [],
        listnguoidat: []
      }
    },
    created: function () {
      this.loadPage(1);
      this.loadphong();
    },
    methods: {
      myChangeEvent(val){
        console.log(val);
      },
      mySelectEvent({id, text}){
        console.log({id, text})
      },

      validateSearch () {
        this.message.batdau = ''
        this.message.ketthuc = ''
        this.message.tungay = ''
        this.message.denngay = ''
        this.message.ngaydatphong = ''
        let resultCheck = true;
        if (this.searchRoom.batdau === '' || this.searchRoom.batdau === null
          || typeof (this.searchRoom.batdau) === 'undefined') {
          this.message.batdau = 'Trường không được để trống!'
          resultCheck = false
        }

        if (this.searchRoom.ketthuc === '' || this.searchRoom.ketthuc === null
          || typeof (this.searchRoom.ketthuc) === 'undefined') {

          this.message.ketthuc = 'Trường không được để trống!'
          resultCheck = false
        }

        //xét nếu check dataAdd.batdau và dataAdd.ketthuc ở trên có valid -> check validate lệch time
        if(resultCheck){
          let arrTimeBatDau = this.searchRoom.batdau.split(":");
          let arrTimeKetThuc = this.searchRoom.ketthuc.split(":");
          let hourBatDau = parseInt(arrTimeBatDau[0]);
          let minuteBatDau = parseInt(arrTimeBatDau[1]);
          let hourKetThuc = parseInt(arrTimeKetThuc[0]);
          let minuteKetThuc = parseInt(arrTimeKetThuc[1]);
          if((hourBatDau > hourKetThuc) || ((hourBatDau == hourKetThuc) && (minuteBatDau >= minuteKetThuc))) {
            this.message.ketthuc = "Thời gian kết thúc phải lớn hơn thời gian bắt đầu!"
            resultCheck = false
          }
        }

        if(!this.isDinhki){
          if (this.searchRoom.ngaydatphong === '' || this.searchRoom.ngaydatphong === null || typeof (this.searchRoom.ngaydatphong) === 'undefined') {
            this.message.ngaydatphong = 'Trường không được để trống!'
            resultCheck = false
          }
        }
        else {
          if (this.searchRoom.tungay === '' || this.searchRoom.tungay === null || typeof (this.searchRoom.tungay) === 'undefined') {
            this.message.tungay = 'Trường không được để trống!'
            resultCheck = false
          }
          if (this.searchRoom.denngay === '' || this.searchRoom.denngay === null || typeof (this.searchRoom.denngay) === 'undefined') {
            this.message.denngay = 'Trường không được để trống!'
            resultCheck = false
          }
          /*console.log("validate thu = "+this.dataAdd.thu)
          if (this.dataAdd.thu === '' || this.dataAdd.thu.length==0 || this.dataAdd.thu === null || typeof (this.dataAdd.thu) === 'undefined') {
            this.message.thu = 'Chọn ít nhất 1 ngày trong tuần!'
            resultCheck = false
          }*/
        }
        return resultCheck
      },
      async loadPage (page) {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/rooms/searchByExceptLichTrinh`,{
            params: {
              page: page,
              batdau: this.searchRoom.batdau,
              ketthuc: this.searchRoom.ketthuc,
              ngaydatphong: this.searchRoom.ngaydatphong,
              thu: this.searchRoom.thu,
              tungay: this.searchRoom.tungay,
              denngay: this.searchRoom.denngay,
              isDinhki: this.searchRoom.isDinhki,
              idPhongHop: this.searchRoom.idPhongHop,
              loaiPhong: this.searchRoom.loaiPhong,
              soluong: this.searchRoom.soluong
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
        let isValid = this.validateSearch();
        if(isValid==false) return;
        this.showLichTrinhThoaManDaDat = false
        console.log('gọi đến hàm search')
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/rooms/searchByExceptLichTrinh`,{
            params: {
              page: 1,
              batdau: this.searchRoom.batdau,
              ketthuc: this.searchRoom.ketthuc,
              ngaydatphong: this.searchRoom.ngaydatphong,
              thu: this.searchRoom.thu,
              tungay: this.searchRoom.tungay,
              denngay: this.searchRoom.denngay,
              isDinhki: this.searchRoom.isDinhki,
              idPhongHop: this.searchRoom.idPhongHop,
              loaiPhong: this.searchRoom.loaiPhong,
              soluong: this.searchRoom.soluong
            }
          })
          this.page = response.data
          this.page.pageCount = CommonJs.getPageCount(this.page);
          this.page.pageList = CommonJs.getPageList(this.page)
          if(this.page.rowCount == 0) this.loadPageLichTrinhDaDat(1);
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async loadphong () {
        const response = await axios.get(`/api/admin/rooms/danhsachphong`,{
          params: {
            loai_phong: this.searchRoom.loaiPhong
          }
        })
        this.listphong = response.data.listphong
        console.log(this.listphong)
      },
      async isdinhki() {
        if (this.searchRoom.isDinhki == false) {

        }
      },
      async loadPageLichTrinhDaDat(page){
        try {
          // eslint-disable-next-line no-undef
          /*this.searchRoom.idPhongHop = this.phonghopSelected!=null ? this.phonghopSelected.id : this.searchRoom.idPhongHop*/
          /*const response = await axios.get(`/api/admin/lichtrinh/searchLichTrinhDaDat`, {
              params: {
                page: page,
                batdau: this.searchRoom.batdau,
                ketthuc: this.searchRoom.ketthuc,
                ngaydatphong: this.searchRoom.ngaydatphong,
                thu: this.searchRoom.thu,
                tungay: this.searchRoom.tungay,
                denngay: this.searchRoom.denngay,
                isDinhki: this.searchRoom.isDinhki,
                idPhongHop: this.searchRoom.idPhongHop,
                loaiPhong: this.searchRoom.loaiPhong
              }
            }
          )*/
          const response = await axios.get(`/api/admin/lichtrinh/searchLichTrinhCanYeuCauNhongPhong`, {
            params: {
              page: page,
              idPhongHop: this.searchRoom.ten_phong,
              batdau: this.searchRoom.batdau,
              ketthuc: this.searchRoom.ketthuc,
              ngaydatphong: this.searchRoom.ngaydatphong,
              tungay: this.searchRoom.tungay,
              denngay: this.searchRoom.denngay,

              /*idNguoiDat: this.userLoggedOn.id,*/
              thu: this.searchRoom.thu,
              isDinhKi: this.searchRoom.isDinhki,
              soluong: this.searchRoom.soluong
            }}
          )
          this.pageLichTrinhThoaManDaDat = response.data
          if (this.pageLichTrinhThoaManDaDat.rowCount > 0) this.showLichTrinhThoaManDaDat = true
          this.pageLichTrinhThoaManDaDat.pageCount = CommonJs.getPageCount(this.pageLichTrinhThoaManDaDat)
          this.pageLichTrinhThoaManDaDat.pageList = CommonJs.getPageList(this.pageLichTrinhThoaManDaDat)
        } catch (error) {
          if (error) {
            console.log("co loi xay ra tai ham loadPageLichTrinhDaDat()")
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async strToDate(dateStr) {
        var dateArr = dateStr.split('/');
        return new Date(dateArr[2], dateArr[1] - 1, dateArr[0]);
      }


    }
  }


</script>
