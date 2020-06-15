import Ls from './ls'

export default {
  async login (loginData) {
    try {
      // eslint-disable-next-line no-undef
      let response = await axios.post('/api/auth/login', loginData)

      Ls.set('auth.token', response.data.token)
      // eslint-disable-next-line no-undef
      toastr['success']('Đăng nhập thành công!', 'Success')
      return response.data.token
    } catch (error) {
      if (error.response.status === 401) {
        // eslint-disable-next-line no-undef
        toastr['error']('Xác thực thất bại', 'Error')
      } else {
        // Something happened in setting up the request that triggered an Error
        console.log('Error', error.message)
      }
    }
  },

  async logout () {
    try {
      // eslint-disable-next-line no-undef
      await axios.get('/api/auth/logout')

      Ls.remove('auth.token')
      // eslint-disable-next-line no-undef
      toastr['success']('Đăng xuất thành công!', 'Success')
    } catch (error) {
      console.log('Error', error.message)
    }
  },

  async check () {
    // eslint-disable-next-line no-undef
    let response = await axios.get('/api/auth/check')

    return !!response.data.authenticated
  },

  async isAdmin () {
    // eslint-disable-next-line no-undef
    let response = await axios.get('/api/auth/isAdmin')

    return !!response.data.isAdmin
  }
}
