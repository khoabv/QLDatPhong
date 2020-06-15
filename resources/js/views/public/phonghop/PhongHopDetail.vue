<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Chi tiết phòng họp</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">chi tiết phòng họp</a></li>
      </ol>

    </div>
    <div class="card">
      <form @submit.prevent="validateBeforeSubmit" class="form">
        <div class="card-header">
          <h6>THÔNG TIN ĐẶT PHÒNG</h6>
          <div class="card-actions"/>
        </div>
        <!--<div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Phòng số</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="dataLichTrinh.idphong" class="custom-select">
                <option value="">Chọn phòng cần đặt</option>
                <option v-for="(item) in listphong" v-bind:value="item.id">{{item.ten_phong}}</option>

              </select>
            </div>
            <div class="form-group col-md-2">
              <label>Người đặt</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="dataUpdate.idnguoidat" class="custom-select">
                <option value="">Chọn người đặt phòng</option>
                <option v-for="(item) in listnguoidat" v-bind:value="item.id">{{item.email}}</option>

              </select>
            </div>
          </div>
        </div>-->

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label class="required">Thời gian từ</label>
            </div>
            <div class="form-group col-md-3">
              <Select2 v-model="dataLichTrinh.batdau" :options="listTime"/>
              <!--<datetime format="H:i:s" v-model="dataLichTrinh.batdau"></datetime>-->
              <div class="message_invalid">
                {{ message.batdau }}
              </div>
            </div>
            <div class="form-group col-md-2">
              <label class="required">đến</label>
            </div>
            <div class="form-group col-md-3">
              <Select2 v-model="dataLichTrinh.ketthuc" :options="listTime"/>
              <!--<datetime format="H:i:s" v-model="dataLichTrinh.ketthuc"></datetime>-->
              <div class="message_invalid">
                {{ message.ketthuc }}
              </div>
              <!-- <input type="password" id="inputLastName" placeholder="Last Name"class="form-control">-->
            </div>
          </div>
        </div>
        <div class="row" v-if="isDinhki==false">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label class="required">Ngày đặt</label>
            </div>
            <div class="form-group col-md-3">
              <datetime format="YYYY-MM-DD" v-model="dataLichTrinh.ngaydatphong"></datetime>
              <div class="message_invalid">
                {{ message.ngaydatphong }}
              </div>
              <!-- <input type="password" id="inputLastName" placeholder="Last Name"class="form-control">-->
            </div>
          </div>
        </div>

        <div class="row" v-if="isDinhki==true">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label class="required">Thời gian từ ngày</label>
            </div>
            <div class="form-group col-md-3">
              <!-- <datetime format="DD/MM/YYYY" v-model="dataUpdate.tungay"></datetime>-->
              <datetime format="YYYY-MM-DD" v-model="dataLichTrinh.tungay"></datetime>
              <div class="message_invalid">
                {{ message.tungay }}
              </div>
            </div>
            <div class="form-group col-md-2">
              <label class="required">đến ngày</label>
            </div>
            <div class="form-group col-md-3">
              <datetime format="YYYY-MM-DD" v-model="dataLichTrinh.denngay"></datetime>
              <div class="message_invalid">
                {{ message.denngay }}
              </div>
            </div>
          </div>
        </div>
        <div class="row" v-if="isDinhki==true" >
          <div class="form-row col-md-12 margin">

            <div class="form-group col-md-1">

              <input type="checkbox" name="thu" value="2" placeholder=""
                     v-model="dataLichTrinh.thu">Thứ 2
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="3" placeholder=""
                     v-model="dataLichTrinh.thu">Thứ 3
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="4" placeholder=""
                     v-model="dataLichTrinh.thu">Thứ 4
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="5" placeholder=""
                     v-model="dataLichTrinh.thu">Thứ 5
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="6" placeholder=""
                     v-model="dataLichTrinh.thu">Thứ 6
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="7" placeholder=""
                     v-model="dataLichTrinh.thu">Thứ 7
            </div>

            <div class="form-group col-md-1">
              <input type="checkbox" name="thu" value="CN" placeholder=""
                     v-model="dataLichTrinh.thu">Chủ nhật
            </div>

          </div>
          <div class="message_invalid">
            {{ message.thu }}
          </div>
        </div>


        <div class="row">
          <div class="form-row col-md-12 margin">

            <div class="form-group col-md-3">
              <input type="checkbox" name="isdinhki" v-on:change="isdinhki()" placeholder="Nhập tên phòng để tìm kiếm"
                     v-model="isDinhki">Định kì
            </div>
          </div>
        </div>
        <div class="form-row center">

          <button class="btn btn-success">
            Đặt phòng
          </button>

          <router-link to="/">
            <a class="btn btn-secondary">
              Hủy
            </a>
          </router-link>

        </div>
        <div class="line line-lg"></div>
      </form>
    </div>


    <div class="card form">
      <div class="card-header">
        <h6>THÔNG TIN PHÒNG</h6>
        <div class="card-actions"/>
      </div>
      <form @submit.prevent="validateBeforeSubmit" class="form">
        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2 bold">
              <label>Tên phòng:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataPhongHop.ten_phong}}
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2 bold">
              <label>Mô tả:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataPhongHop.mo_ta}}
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2 bold">
              <label>Trạng thái:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataPhongHop.trang_thai==0?'Đang bảo trì':'Đang sử dụng'}}
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2 bold">
              <label>Loại phòng:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataPhongHop.loai_phong===0?'Hội thảo':dataPhongHop.loai_phong===1?'Phỏng vấn':dataPhongHop.loai_phong===2?"Họp":dataPhongHop.loai_phong===3?"Đào tạo":"Khác"}}
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2 bold">
              <label>Sức chứa:</label>
            </div>
            <div class="form-group col-md-3">
              {{dataPhongHop.soluong}} chỗ ngồi
            </div>
          </div>
        </div>

      </form>
    </div>


    <div class="card">
      <div class="card-header">
        <h6>Danh sách lịch trình đã đặt tại phòng này</h6>
        <div class="card-actions"/>
      </div>
      <div class="card-body">
        <table class="table table-striped table-bordered m-b-none text-sm">
          <thead>
          <tr>
            <th class="text-center">STT</th>
            <th class="text-center">Mã lịch trình</th>
            <th class="text-center">Ngày bắt đầu</th>
            <th class="text-center">Ngày kết thúc</th>
            <th class="text-center">Thời gian bắt đầu</th>
            <th class="text-center">Thời gian kết thúc</th>
          </tr>

          </thead>
          <tbody>
          <tr v-for="(item, index) in pageLichTrinhOfRoom.items">
            <td class="align-center">{{(pageLichTrinhOfRoom.pageNumber-1)*pageLichTrinhOfRoom.numberPerPage
              + index+1}}
            </td>
            <td class="align-center">{{item.malichtrinh}}</td>
            <td class="align-center">{{item.ngaybatdau}}</td>
            <td class="align-center">{{item.ngayketthuc}}</td>
            <td class="align-center">{{item.thoigianbatdau}}</td>
            <td class="align-center">{{item.thoigianketthuc}}</td>

          </tr>

          </tbody>
        </table>
        <footer class="panel-footer">
          <div class="row">
            <div class="col-sm-12 col-md-5">
              <div class="dataTables_info" id="users-datatable_info" role="status" aria-live="polite">Tổng số <code>{{pageLichTrinhOfRoom.rowCount}}</code>
                dữ liệu
              </div>
            </div>
            <div class="col-sm-12 col-md-7">
              <div class="dataTables_paginate paging_simple_numbers" id="users-datatable_paginate">
                <ul class="pagination">
                  <li v-if="pageLichTrinhOfRoom.pageNumber>1"><a href="javascript:void(0)"
                                                  @click="loadPageLichTrinhOfRoomInit(1)">«</a></li>
                  <li v-for="pageNum in pageLichTrinhOfRoom.pageList">
                    <a href="javascript:void(0)" v-if="pageNum==pageLichTrinhOfRoom.pageNumber"
                       style="color:mediumvioletred;"> {{pageNum}}</a>
                    <a href="javascript:void(0)" v-if="pageNum!=pageLichTrinhOfRoom.pageNumber"
                       @click="loadPageLichTrinhOfRoomInit(pageNum)"> {{pageNum}}</a>
                  </li>
                  <li v-if="pageLichTrinhOfRoom.pageNumber<pageLichTrinhOfRoom.pageCount"><a href="javascript:void(0)"
                                                               @click="loadPageLichTrinhOfRoomInit(pageLichTrinhOfRoom.pageCount)">»</a>
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
  import Select2 from 'v-select2-component';
  import CommonJs from '../../../common'
  import Constants from '../../../Constants'

  export default {
    components: {
      'Select2': Select2,
      datetime
    },
    props: {
      batdau: {
        type: String,
        required: false,
        default:''
      },
      ketthuc: {
        type: String,
        default:''
      },
      ngaydatphong: {
        type: String,
        default:''
      },
      tungay: {
        type: String,
        default:''
      },
      denngay: {
        type: String,
        default:''
      },
      isDinhki2: {
        type: String,
        default:false
      },
      thu: {
        type: String,
        default:[]
      }
    },
    /* name: 'UsersAdd', */
    data() {
      return {
        listTime:Constants.listTime,
        dataPhongHop: {
          id: '',
          ten_phong: '',
          mo_ta: '',
          trang_thai: '',
          loai_phong:'',
          soluong:''
        },
        dataLichTrinh: {
          batdau: '',
          ketthuc: '',
          /*idphong:'',*/
          ten_phong: '',
          ngaydatphong: '',
          tennguoidat: '',
          idnguoidat:'',
          thu: [],
          tungay: '',
          denngay: '',
          isDinhki: false
        },
        isDinhki: false,
        message: {
          batdau: '',
          ketthuc: '',
          ngaydatphong:'',
          tungay: '',
          denngay: '',
          thu: '',
        },
        listphong: [],
        listnguoidat: [],
        userLoggedOn:{},
        isExistedLichTrinh:false,
        pageLichTrinhOfRoom: CommonJs.page
      }
    },
    created: function () {
      this.getRoomById(this.$route.params.id);
      // this.loadPageLichTrinhOfRoom(1);
      this.parseRequestParamToData();

    },

    methods: {
      async parseRequestParamToData() {
        this.dataLichTrinh.batdau = this.batdau
        console.log("dataLichTrinh.batdau = "+this.dataLichTrinh.batdau)
        this.dataLichTrinh.ketthuc = this.ketthuc
        this.dataLichTrinh.ngaydatphong = this.ngaydatphong
        this.dataLichTrinh.thu = this.thu.split(",")
        this.dataLichTrinh.tungay = this.tungay
        this.dataLichTrinh.denngay = this.denngay
        this.dataLichTrinh.isDinhki = this.isDinhki2 === 'true';
        console.log("isDinhki2 = "+this.isDinhki2)
        this.isDinhki = this.dataLichTrinh.isDinhki
        console.log("isDinhki = "+this.isDinhki)

      },
      async getRoomById (id) {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/rooms/get/${id}`)
          this.dataPhongHop = response.data
          this.loadPageLichTrinhOfRoomInit(1);
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async validateBeforeSubmit() {
        let isValid = this.validate();
        if(!isValid) return;
        this.dataLichTrinh.isDinhki = this.isDinhki;
        this.dataLichTrinh.ten_phong = this.dataPhongHop.id
        this.dataLichTrinh.idnguoidat = this.userLoggedOn.id;

        this.checkTrungLichTrinh();
        /*console.log("value check existed = "+isExist)
        if(isExist==true){
          window.toastr['error']('Lịch đặt này đã được đặt bởi người khác!', 'Error')
          return;
        }*/

       /* let response = await axios.post('/api/admin/lichtrinh/addLichTrinhByCustomer', this.dataLichTrinh)
        if (response.data.result === true) {
          window.toastr['success'](response.data.message, 'Success')
          window.location.href = '/lichtrinh/all'
        } else window.toastr['error'](response.data.message, 'Error')*/

      },
      async submit() {
        let response = await axios.post('/api/admin/lichtrinh/addLichTrinhByCustomer', this.dataLichTrinh)
        if (response.data.result === true) {
          window.toastr['success'](response.data.message, 'Success')
          window.location.href = '/lichtrinh/all'
        } else window.toastr['error'](response.data.message, 'Error')

      },
      validate () {
        this.message.batdau = ''
        this.message.ketthuc = ''
        this.message.ngaydatphong = ''
        this.message.tungay = ''
        this.message.denngay = ''
        this.message.thu = ''
        let resultCheck = true;
        if (this.dataLichTrinh.batdau === '' || this.dataLichTrinh.batdau === null || typeof (this.dataLichTrinh.batdau) === 'undefined') {
          this.message.batdau = 'Trường không được để trống!'
          resultCheck = false
        }

        if (this.dataLichTrinh.ketthuc === '' || this.dataLichTrinh.ketthuc === null || typeof (this.dataLichTrinh.ketthuc) === 'undefined') {
          this.message.ketthuc = 'Trường không được để trống!'
          resultCheck = false
        }

        //xét nếu check dataAdd.batdau và dataAdd.ketthuc ở trên có valid -> check validate lệch time
        if(resultCheck){
          let arrTimeBatDau = this.dataLichTrinh.batdau.split(":");
          let arrTimeKetThuc = this.dataLichTrinh.ketthuc.split(":");
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
          if (this.dataLichTrinh.ngaydatphong === '' || this.dataLichTrinh.ngaydatphong === null || typeof (this.dataLichTrinh.ngaydatphong) === 'undefined') {
            this.message.ngaydatphong = 'Trường không được để trống!'
            resultCheck = false
          }
        }
        else {
          if (this.dataLichTrinh.tungay === '' || this.dataLichTrinh.tungay === null || typeof (this.dataLichTrinh.tungay) === 'undefined') {
            this.message.tungay = 'Trường không được để trống!'
            resultCheck = false
          }
          if (this.dataLichTrinh.denngay === '' || this.dataLichTrinh.denngay === null || typeof (this.dataLichTrinh.denngay) === 'undefined') {
            this.message.denngay = 'Trường không được để trống!'
            resultCheck = false
          }
          console.log("validate thu = "+this.dataLichTrinh.thu)
          if (this.dataLichTrinh.thu === '' || this.dataLichTrinh.thu.length==0 || this.dataLichTrinh.thu === null || typeof (this.dataLichTrinh.thu) === 'undefined') {
            this.message.thu = 'Chọn ít nhất 1 ngày trong tuần!'
            resultCheck = false
          }
        }
        return resultCheck
      },
      async checkTrungLichTrinh() {
          try {
            // eslint-disable-next-line no-undef
            const response = await axios.get(`/api/admin/lichtrinh/checkExistLichTrinh`, {
              params: {
                page: 1,
                idPhongHop: this.dataPhongHop.id,
                batdau: this.dataLichTrinh.batdau,
                ketthuc: this.dataLichTrinh.ketthuc,
                ngaydatphong: this.dataLichTrinh.ngaydatphong,
                tungay: this.dataLichTrinh.tungay,
                denngay: this.dataLichTrinh.denngay,

                /*idNguoiDat: this.userLoggedOn.id,*/
                thu: this.dataLichTrinh.thu,
                isDinhKi: this.dataLichTrinh.isDinhki
              }}
            )
            this.page = response.data
            console.log("items = "+this.page.items)
            if(this.page.items!=null && this.page.items.length>0) {
              window.toastr['error']('Lịch đặt này đã được đặt bởi người khác!', 'Error')
              return;
              /*this.isExistedLichTrinh = true;*/
            }

            else {
              /*this.isExistedLichTrinh = false;*/
              this.submit();
            }
          } catch (error) {
            if (error) {
              window.toastr['error']('Có lỗi xảy ra', 'Error')
            }
          }

      },
      async loadphong() {
        const dsphong = await axios.get(`/api/admin/rooms/danhsachphong`);
        this.listphong = dsphong.data.listphong;
        //this.searchCondition.isDinhki == false;
        const dsnguoidat = await axios.get('/api/admin/users/danhsachnguoidung');
        this.listnguoidat = dsnguoidat.data.nguoidat;
        console.log(this.listnguoidat);
        console.log(this.listphong);
      },

      /*async loadPageLichTrinhOfRoom () {
        try {
          // eslint-disable-next-line no-undef
          console.log('current page = '+this.page.pageNumber)
          const response = await axios.get(`/api/admin/lichtrinh/get?page=`+this.page.pageNumber)
          this.page = response.data
          this.page.pageCount = CommonJs.getPageCount(this.page)
          this.page.pageList = CommonJs.getPageList(this.page)
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },*/
      async loadPageLichTrinhOfRoomInit (page) {
        console.log('gọi đến hàm search')
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/lichtrinh/get`, {
            params: {
              page: page,
              idPhongHop: this.dataPhongHop.id,
              searchChoDatPhong: true
            }
          })
          this.pageLichTrinhOfRoom = response.data
          this.pageLichTrinhOfRoom.pageCount = CommonJs.getPageCount(this.pageLichTrinhOfRoom)
          this.pageLichTrinhOfRoom.pageList = CommonJs.getPageList(this.pageLichTrinhOfRoom)
        } catch (error) {
          if (error) {
            console.log("co loi xay ra o ham loadPageLichTrinhOfRoom()")
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async loadPageLichTrinhOfRoom (page) {
        console.log('gọi đến hàm search')
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/lichtrinh/get`, {
            params: {
              page: page,
              idPhongHop: this.dataPhongHop.id,
              batdau: this.dataLichTrinh.batdau,
              ketthuc: this.dataLichTrinh.ketthuc,
              ngaydatphong: this.dataLichTrinh.ngaydatphong,
              thu: this.dataLichTrinh.thu
            }
          })
          this.pageLichTrinhOfRoom = response.data
          this.pageLichTrinhOfRoom.pageCount = CommonJs.getPageCount(this.pageLichTrinhOfRoom)
          this.pageLichTrinhOfRoom.pageList = CommonJs.getPageList(this.pageLichTrinhOfRoom)
        } catch (error) {
          if (error) {
            console.log("co loi xay ra o ham loadPageLichTrinhOfRoom()")
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },

      async isdinhki() {
        /*console.log('is dinhky = '+this.dataUpdate.isDinhki)
        if (this.dataUpdate.isDinhki == false) {

        }*/

      },
      async strToDate(dateStr) {
        var dateArr = dateStr.split('/');
        return new Date(dateArr[2], dateArr[1] - 1, dateArr[0]);
      }

    }
  }


</script>
