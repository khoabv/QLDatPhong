<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">PHẦN MỀM QUẢN LÝ ĐẶT PHÒNG</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <!--<li class="breadcrumb-item"><a href="#">Đặt phòng</a></li>-->
      </ol>

    </div>
    <div class="card">
      <div class="form">
        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Tên phòng</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="searchRoom.idPhongHop"  class="custom-select .ls-select2">
                <option value="">Tất cả phòng họp</option>
                <option v-for="(item) in listphong" v-bind:value="item.id">{{item.ten_phong}}</option>

              </select>
            </div>

            <div class="form-group col-md-2">
              <label>Tên phòng select2</label>
            </div>
            <div class="form-group col-md-3">
              <!--<Select2 v-model="searchRoom.idPhongHop" :options="listphong"/>-->
              <multiselect v-model="value" :options="options" :custom-label="nameWithLang" placeholder="Select one" label="name" track-by="name"></multiselect>
            </div>
           <!-- <div class="col-sm-5">
              <Select2 v-model="searchRoom.idPhongHop" :options="myOptions">
                <option disabled value="0">Select one</option>
              </Select2>
            </div>-->


          </div>
        </div>
        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Thời gian từ</label>
            </div>
            <!--<div class="form-group col-md-3">
              <datetime format="H:i" v-model="searchRoom.batdau"></datetime>
            </div>-->
            <div class="form-group col-md-3">
              <Select2 v-model="searchRoom.batdau" :options="listTime"/>
            </div>
            <div class="form-group col-md-2">
              <label>đến</label>
            </div>
            <div class="form-group col-md-3">
              <!--<datetime format="H:i" v-model="searchRoom.ketthuc"></datetime>-->
              <Select2 v-model="searchRoom.ketthuc" :options="listTime"/>
              <!-- <input type="password" id="inputLastName" placeholder="Last Name"class="form-control">-->
            </div>
          </div>
        </div>
        <div class="row" v-if="searchRoom.isDinhki==false">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Ngày đặt</label>
            </div>
            <div class="form-group col-md-3">
              <datetime format="YYYY-MM-DD" v-model="searchRoom.ngaydatphong"></datetime>

              <!-- <input type="password" id="inputLastName" placeholder="Last Name"class="form-control">-->
            </div>
          </div>
        </div>

        <div class="row" v-if="searchRoom.isDinhki==true">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Thời gian từ ngày</label>
            </div>
            <div class="form-group col-md-3">
              <datetime format="YYYY-MM-DD" v-model="searchRoom.tungay"></datetime>

            </div>
            <div class="form-group col-md-2">
              <label>đến ngày</label>
            </div>
            <div class="form-group col-md-3">
              <datetime format="YYYY-MM-DD" v-model="searchRoom.denngay"></datetime>

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
              <input type="checkbox" name="thu" value="CN" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="searchRoom.thu">Chủ nhật
            </div>

          </div>
        </div>
        <div class="row">
          <div class="form-row col-md-12 margin">

            <div class="form-group col-md-3">
              <input type="checkbox" name="isdinhki" v-on:change="isdinhki()" placeholder="Nhập tên phòng để tìm kiếm"
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


  </div>


</template>

<script type="text/babel">

  import datetime from 'vuejs-datetimepicker';
  import CommonJs from '../../common'
  import Constants from '../../Constants'
  import {TableComponent, TableColumn} from 'vue-table-component'
  // import Select2Component
  import Select2 from 'v-select2-component';
  import Multiselect from 'vue-multiselect'

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
        listTime:Constants.listTime,
        searchRoom: {
          idPhongHop:'',
          batdau: '',
          ketthuc: '',
          ngaydatphong: '',
          thu: [],
          tungay: '',
          denngay: '',
          isDinhki: ''

        },
        message: {
          ten_phong: '',
          mo_ta: '',
          trang_thai: '',
          loai_phong: '',
          soluong: '',
        },
        listphong: [],
        listnguoidat: [],
        value: { name: 'Vue.js', language: 'JavaScript' },
        options: [
          { name: 'Vue.js', language: 'JavaScript' },
          { name: 'Rails', language: 'Ruby' },
          { name: 'Sinatra', language: 'Ruby' },
          { name: 'Laravel', language: 'PHP' },
          { name: 'Phoenix', language: 'Elixir' }
        ]
      }
    },
    created: function () {
      this.loadPage(1);
      this.loadphong();
    },
    methods: {
      nameWithLang ({ name, language }) {
        return `${name} — [${language}]`
      },
      myChangeEvent(val){
        console.log(val);
      },
      mySelectEvent({id, text}){
        console.log({id, text})
      },
      /*async validateBeforeSubmit() {
        let response = await axios.post('/api/admin/lichtrinh/addlichtrinh', this.searchCondition)
        if (response.data.result === true) {
          window.toastr['success'](response.data.message, 'Success')
          window.location.href = '/admin/lichtrinh/all'
        } else window.toastr['error'](response.data.message, 'Error')

      },*/
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
              isDinhki: this.searchRoom.isDinhki
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
          const response = await axios.get(`/api/admin/rooms/searchByExceptLichTrinh`,{
            params: {
              page: 1,
              batdau: this.searchRoom.batdau,
              ketthuc: this.searchRoom.ketthuc,
              ngaydatphong: this.searchRoom.ngaydatphong,
              thu: this.searchRoom.thu,
              tungay: this.searchRoom.tungay,
              denngay: this.searchRoom.denngay,
              isDinhki: this.searchRoom.isDinhki
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
      async loadphong () {
        const response = await axios.get(`/api/admin/rooms/danhsachphong`)
        this.listphong = response.data.listphong
        console.log(this.listphong)
      },
      async isdinhki() {
        if (this.searchRoom.isDinhki == false) {

        }
      },
      async strToDate(dateStr) {
        var dateArr = dateStr.split('/');
        return new Date(dateArr[2], dateArr[1] - 1, dateArr[0]);
      }


    }
  }


</script>
