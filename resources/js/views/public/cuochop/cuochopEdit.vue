<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Cuộc họp của tôi</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">cuộc họp của tôi</a></li>
        <li class="breadcrumb-item"><a href="#">chỉnh sửa</a></li>
      </ol>

    </div>

    <div class="card">
      <div class="form">
        <div class="card-header">
          <h6>THÔNG TIN LỊCH TRÌNH</h6>
          <div class="card-actions"/>
        </div>

        <div class="form">
          <div class="row">
            <div class="form-row col-md-12 margin">
              <div class="form-group col-md-2">
                <label>Phòng số</label>
              </div>
              <div class="form-group col-md-3">
                <select v-model="dataLichTrinh.idphong" class="custom-select" disabled>
                  <option v-for="(item) in listphong" v-bind:value="item.id">{{item.ten_phong}}</option>

                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-row col-md-12 margin">
              <div class="form-group col-md-2">
                <label>Thời gian từ:</label>
              </div>
              <div class="form-group col-md-3">
                {{dataLichTrinh.batdau}}
              </div>
              <div class="form-group col-md-2">
                <label>đến:</label>
              </div>
              <div class="form-group col-md-3">
                {{dataLichTrinh.ketthuc}}
              </div>
            </div>
          </div>
          <div class="row" v-if="isDinhki==false">
            <div class="form-row col-md-12 margin">
              <div class="form-group col-md-2">
                <label>Ngày đặt:</label>
              </div>
              <div class="form-group col-md-3">
                {{dataLichTrinh.ngaydatphong}}
              </div>
            </div>
          </div>

          <div class="row" v-if="isDinhki==true">
            <div class="form-row col-md-12 margin">
              <div class="form-group col-md-2">
                <label>Thời gian từ ngày:</label>
              </div>
              <div class="form-group col-md-3">
                {{dataLichTrinh.tungay}}

              </div>
              <div class="form-group col-md-2">
                <label>đến ngày:</label>
              </div>
              <div class="form-group col-md-3">
                {{dataLichTrinh.denngay}}

              </div>
            </div>
          </div>
          <div class="row" v-if="isDinhki==true" >
            <div class="form-row col-md-12 margin">

              <div class="form-group col-md-1">

                <input type="checkbox" name="thu" value="2" placeholder="" disabled
                       v-model="dataLichTrinh.thu">Thứ 2
              </div>

              <div class="form-group col-md-1">
                <input type="checkbox" name="thu" value="3" placeholder="" disabled
                       v-model="dataLichTrinh.thu">Thứ 3
              </div>

              <div class="form-group col-md-1">
                <input type="checkbox" name="thu" value="4" placeholder="" disabled
                       v-model="dataLichTrinh.thu">Thứ 4
              </div>

              <div class="form-group col-md-1">
                <input type="checkbox" name="thu" value="5" placeholder="" disabled
                       v-model="dataLichTrinh.thu">Thứ 5
              </div>

              <div class="form-group col-md-1">
                <input type="checkbox" name="thu" value="6" placeholder="" disabled
                       v-model="dataLichTrinh.thu">Thứ 6
              </div>

              <div class="form-group col-md-1">
                <input type="checkbox" name="thu" value="7" placeholder="" disabled
                       v-model="dataLichTrinh.thu">Thứ 7
              </div>

              <div class="form-group col-md-1">
                <input type="checkbox" name="thu" value="CN" placeholder="" disabled
                       v-model="dataLichTrinh.thu">Chủ nhật
              </div>

            </div>
          </div>


          <div class="row">
            <div class="form-row col-md-12 margin">
              <div class="form-group col-md-2">
                <label>Loại lịch trình:</label>
              </div>
              <div class="form-group col-md-3">
                {{isDinhki?'Định kỳ':'Không định kỳ'}}
              </div>

              <!--<div class="form-group col-md-3">
                <input type="checkbox" name="isdinhki" v-on:change="isdinhki()" placeholder="Nhập tên phòng để tìm kiếm"
                       v-model="isDinhki" disabled>Định kì
              </div>-->
            </div>
          </div>
        </div>


        <div class="line line-lg"></div>
      </div>
    </div>

    <div class="card form">
      <div class="card-header">
        <h6>THÔNG TIN CUỘC HỌP</h6>
        <div class="card-actions"/>
      </div>
      <div class="form">
        <!-- <div class="row">
           <div class="form-row col-md-12 margin">
             <div class="form-group col-md-2">
               <label>Phòng số</label>
             </div>
             <div class="form-group col-md-3">
               <select v-model="dataEdit.idphong" class="custom-select" disabled>
                 <option value="">Chọn phòng họp</option>
                 <option v-for="(item) in listphong" v-bind:value="item.id">{{item.ten_phong}}</option>

               </select>
             </div>
           </div>
         </div>-->

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Tên cuộc họp</label>
            </div>
            <div class="form-group col-md-8">
              <input
                v-model.trim="dataEdit.tencuochop"
                type="text"
                class="form-control"
                placeholder="Nhập tên cuộc họp"
              >
              <span class="message_invalid">{{ message.tencuochop }}</span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Nội dung cuộc họp</label>
            </div>
            <div class="form-group col-md-8">
                <textarea rows="3" class="form-control"
                          v-model="dataEdit.noidungcuochop"></textarea>

            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Nội dung tổng kết</label>
            </div>
            <div class="form-group col-md-8">
                <textarea rows="3" class="form-control"
                          v-model="dataEdit.noidungtongket"></textarea>
            </div>
          </div>
        </div>

        <!--<div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Trạng thái</label>
            </div>
            <div class="form-group col-md-8">
              {{dataEdit.trangthai}}
            </div>
          </div>
        </div>-->

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Trạng thái</label>
            </div>
            <div class="form-group col-md-3">
              <select v-model="dataEdit.trangthai" class="custom-select" >
                <option value="0">Chưa hoàn thành</option>
                <option value="1">Đã hoàn thành</option>
              </select>
              <span class="message_invalid">{{ message.trangthai }}</span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-row col-md-12 margin">
            <div class="form-group col-md-2">
              <label>Email thành viên tham gia</label>
            </div>
            <div class="form-group col-md-8">
              <textarea rows="3" class="form-control" v-model="strListEmailThanhVien" >
                <!--{{strListEmailThanhVien}}-->
              </textarea>
            </div>
          </div>
        </div>

        <div class="form-row center">
          <button class="btn btn-success" @click="guiThongBaoCuocHop()">
            Gửi thông báo cuộc họp
          </button>
          <button class="btn btn-success" @click="validateBeforeSubmit">
            Lưu
          </button>
          <router-link to="/cuochop/all">
            <a class="btn btn-secondary">
              Hủy
            </a>
          </router-link>

        </div>
        <div class="line line-lg"></div>
      </div>
    </div>

  </div>


</template>

<script type="text/babel">

  import datetime from 'vuejs-datetimepicker';
  import CommonJs from '../../../common'

  export default {
    /* name: 'UsersAdd', */
    data() {
      return {
        dataLichTrinh: {
          batdau: '',
          ketthuc: '',
          ten_phong: '',
          ngaydatphong: '',
          tennguoidat: '',
          thu: [],
          tungay: '',
          denngay: '',
          isDinhki: false
        },
        isDinhki: '',
        dataEdit: {
          id:'',
          idphong: '',
          tencuochop:'',
          noidungcuochop:'',
          trangthai:'',
          noidungtongket:'',
          idlichtrinh:'',
          emailThanhVien:''

        },
        dataThanhVien:{
          id:'',
          email:'',
          id_cuochop:''
        },
        message: {
          tencuochop: '',
          trangthai: ''
        },
        listphong: [],
        listThanhVien: [],
        strListEmailThanhVien: ""
      }
    },
    created: function () {
      this.getCuocHopById(this.$route.params.id)
      this.loadphong();

    },
    components: {datetime},
    methods: {
      async getCuocHopById (id) {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/cuochop/get/${id}`)
          this.dataEdit = response.data.cuochop
          /*this.dataAdd.idlichtrinh = this.dataLichTrinh.id
          this.dataAdd.idphong = this.dataLichTrinh.idphong*/
          this.loadAllThanhVien(this.dataEdit.id);
          this.getLichTrinhById(this.dataEdit.idlichtrinh)

        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async getLichTrinhById (id) {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/lichtrinh/get/${id}`)
          this.dataLichTrinh = response.data
          this.dataLichTrinh.ngaydatphong = response.data.ngaybatdau
          this.dataLichTrinh.tungay = response.data.ngaybatdau
          this.dataLichTrinh.denngay = response.data.ngayketthuc
          this.dataLichTrinh.batdau = response.data.thoigianbatdau
          this.dataLichTrinh.ketthuc = response.data.thoigianketthuc
          this.dataLichTrinh.thu = response.data.thu.split(',');
          if(response.data.loailichtrinh===0) this.isDinhki = false;
          else this.isDinhki = true;

          this.dataEdit.idlichtrinh = this.dataLichTrinh.id
          this.dataEdit.idphong = this.dataLichTrinh.idphong

        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async guiThongBaoCuocHop() {
        let response = await axios.post('/api/admin/cuochop/guithongbao', this.dataEdit)
        if (response.data.result === true) {
          window.toastr['success'](response.data.message, 'Success')
        } else window.toastr['error'](response.data.message, 'Error')

      },
      async validateBeforeSubmit() {
        let isValid = this.validate();
        if(!isValid) return;
        let response = await axios.post('/api/admin/cuochop/update', this.dataEdit)
        if (response.data.result === true) {
          window.toastr['success'](response.data.message, 'Success')
          window.location.href = '/cuochop/all'
        } else window.toastr['error'](response.data.message, 'Error')

      },
      validate () {
        this.message.tencuochop = ''
        this.message.trangthai = ''
        let resultCheck = true;
        if (this.dataEdit.tencuochop === '' || this.dataEdit.tencuochop === null || typeof (this.dataEdit.tencuochop) === 'undefined') {
          this.message.tencuochop = 'Trường không được để trống!'
          resultCheck = false
        }

        if (this.dataEdit.trangthai === '' || this.dataEdit.trangthai === null || typeof (this.dataEdit.trangthai) === 'undefined') {
          this.message.trangthai = 'Trường không được để trống!'
          resultCheck = false
        }
        return resultCheck
      },
      async loadAllThanhVien (id_cuochop) {
        try {
          // eslint-disable-next-line no-undef
          const response = await axios.get(`/api/admin/cuochop/getAllThanhVien`,{
            params: {
              id_cuochop: id_cuochop
            }
          })
          this.listThanhVien = response.data.listThanhVien
          this.arrayToStringEmailThanhVien(this.listThanhVien)
        } catch (error) {
          if (error) {
            window.toastr['error']('Có lỗi xảy ra', 'Error')
          }
        }
      },
      async arrayToStringEmailThanhVien(arr){
        console.log("arr object email thanh vien = "+arr)
        let result = "";
        for(let i = 0;i<arr.length;i++){
          if(i==(arr.length-1))  result += arr[i].email;
          else result += arr[i].email + ",";
        }
        this.strListEmailThanhVien = result.trim();
        console.log("result arrayToStringEmailThanhVien = "+result)
      },
      async loadphong() {
        const dsphong = await axios.get(`/api/admin/rooms/danhsachphong`);
        this.listphong = dsphong.data.listphong;
        /* this.searchCondition.isDinhki == false;*/
      },
      async isdinhki() {
        /*if (this.searchCondition.isDinhki == false) {

        }*/
      },
      async strToDate(dateStr) {
        var dateArr = dateStr.split('/');
        return new Date(dateArr[2], dateArr[1] - 1, dateArr[0]);
      }


    }
  }


</script>
