<template>
    <div class="container">
        <div class="row justify-content-center m-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Book Slot {{ user.name }} </div>

                    <div class="card-body">
                        <div v-if=" user.userType  === 'admin' || user.userType  === 'patient'">
                        <div class="form-group">
                          <label for="doctor">Doctor</label>
                          <!-- <input type="text" class="form-control" name="doctor" id="doctor" v-model="doctor" aria-describedby="helpdoctor" placeholder=""> -->
                          <select class="form-control" name="doctor" id="doctor" v-model="doctor" placeholder="Select Doctor" @change="changeItem($event)">
                              <option selected="selected">Select Doctor</option>
                              <option v-for="item in docs" :value="item.id" :key="item.name">
                                {{ item.name }}
                            </option>
                          </select>

                        

                          <small id="doctor" class="form-text text-muted">Help text</small>
                        </div>
                        
                        <div class="form-group">
                          <label for="timeSlot">Time-Slot</label>
                          <!-- <input type="text" class="form-control" name="timeSlot" id="timeSlot" v-model="time" aria-describedby="helptimeSlot" placeholder=""> -->
                          <select class="form-control" name="availableSlots" id="availableSlots" v-model="time" placeholder="Select Doctor">
                              <option selected="selected">Available Slots</option>
                              <option v-for="item in availableSlots">
                                {{ item }}
                            </option>
                          </select>
                          
                          <small id="helptimeSlot" class="form-text text-muted">Help text</small>
                        </div>
                        <button type="button" name="" id="" @click="saveBookSlot()" class="btn btn-primary btn-lg btn-block">Button</button>
                        </div>
                        <table class="table table-bordered table-striped mt-5">
                        <thead class="thead-inverse">
                            <tr>
                                <th> </th>
                                <th>Doctor</th>
                                <th>Time</th>
                                <th>Confirmation</th>
                                <td v-if=" user.userType  === 'admin' || user.userType  === 'doctor'">Confirm </td>  
                                
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(bookslot,index) in bookslots" :key="index">
                                    <td scope="row">{{ ++ index}}</td>
                                    <td>{{bookslot.doctor}}</td>
                                    <td>{{bookslot.time}}</td>
                                    <td> <h6 v-if="bookslot.confirmation  === 1">Confirm</h6> <h6 v-else>Confirmation Pending </h6></td>
                                    <td v-if=" user.userType  === 'admin' || user.userType  === 'doctor'"><a href="#" @click="confirm(bookslot.id)">Confirm</a> </td>  
                                    
                                </tr>
                                
                            </tbody>
                    </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters, mapActions } from "vuex";


    export default {
  methods: {
    saveBookSlot () { 
        console.log(this.doctor);
        if(this.doctor>0 && this.time>0){
              console.log(this.doctor);
            this.axios.post(this.api, {'doctor': this.doctor, 'time': this.time}).then(res =>{
                this.bookslots.push( res.data );
                this.doctor = '';
                this.time = '';
                console.log(res);
            })
        }
    },
    changeItem (event) { 
        console.log(event.target.value);
        this.axios.get(
            axios.defaults.baseURL + 'fetchTimeSlots/' + event.target.value,
            {
                headers: {'Authorization': 'JWT ' + axios.defaults.headers.common['Authorization']},
                params:{
                    // 'id': event.target.value,
                }
            }
        ).then( (response =>{
        console.log('responsetimeslot');
        console.log(response);
        this.availableSlots = response.data;
        // this.bookslots = response.data;
        console.log('responsetimeslot');
        }));
    },
    confirm (index) { 
        console.log(index);
        this.axios.get(
            axios.defaults.baseURL + 'confirm/' + index,
            {
                headers: {'Authorization': 'JWT ' + axios.defaults.headers.common['Authorization']},
                params:{
                    // 'id': event.target.value,
                }
            }
        ).then( (response =>{
        console.log('confirm');
        console.log(response);

        this.axios.get(this.api).then(res =>{
                this.bookslots = res.data;
            })

        // this.bookslots.push( response.data );
        
        // this.availableSlots = response.data;
        // this.bookslots = response.data;
        console.log('confirm');
        }));
    },
    timeSlot () { 
      this.axios.get(
            axios.defaults.baseURL + 'timeSlot',
            {
                headers: {'Authorization': 'JWT ' + axios.defaults.headers.common['Authorization']},
                params:{

                }
            }
        ).then( (response =>{
        
        console.log(response);
        this.docs = response.data;
        // this.bookslots = response.data;
        console.log('response');
        }));
    },
    doctorList () { 
      this.axios.get(
            axios.defaults.baseURL + 'doctorList',
            {
                headers: {'Authorization': 'JWT ' + axios.defaults.headers.common['Authorization']},
                params:{

                }
            }
        ).then( (response =>{
        
        console.log(response);
        this.docs = response.data;
        // this.bookslots = response.data;
        console.log('response');
        }));
    },
  },
    saveBookSlot1 () { 
    //   console.log(this.doctor);
        // if(this.doctor.length>0 && this.time.length>0){
            //   console.log(this.doctor);
            this.axios.post(this.api, {'doctor': this.doctor, 'time': this.time}).then(res =>{
                this.bookslots.push( res.data );
                this.doctor = '';
                this.time = '';
                console.log(res);
            })
        // }
    },
  beforeMount(){
    this.doctorList()
 },
  data () {
    return {
        availableSlots: [],
        docs: [],
        bookslots:[],
        slot: [],
        api: axios.defaults.baseURL + 'bookslots',
        api1: axios.defaults.baseURL,
        doctor: '',
        time: ''
    }
  },
        mounted() {
            // console.log('Component mounted.')
            this.axios.get(this.api).then(res =>{
                this.bookslots = res.data;
            })
        },

		computed: {
	    	...mapGetters({ user: "getUser"}),
	 	},
    }
</script>

