import Vue from 'vue'
import axios from 'axios'

const client = axios.create({
  baseURL: '/api',
  json: true
})

export default{
  async execute(method, resource, data){
    // let accessToken = await Vue.prototype.$auth.getAccessToken()
    return client({
      method,
      url: resource,
      data,
      headers: {
        // Authorization: `Bearer ${accessToken}`
      }
    }).then(req => {
      return req.data
    })
  },
  get(model ,id){
  	if(id!=undefined){
    	return this.execute('get', `/${model}/${id}`)
  	}
  	else{
    	return this.execute('get', `/${model}`)
  	}
  },
  create(model, data){
    return this.execute('post', `/${model}`, data)
  },
  update(model, data){
    return this.execute('put', `/${model}/${data.id}`, data)
  },
  delete(model, id){
    return this.execute('delete', `/${model}/${id}`)
  }
}