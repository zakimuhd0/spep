<template>
    <div>
        <div class="form-group">
            <label>Select Batch</label>
            <div class=" d-flex">
                <select class='form-control' v-model='batch1' @click='getRecords1()' name='batch1' size='5' autofocus>
                    <option v-for='data in batches1' :value='JSON.stringify([{ id: data.id, text: data.batch }])'>{{ data.batch }}</option>
                </select>
                <div class="p-2"></div>
                <select class='form-control' v-model='batch2' @click='getRecords2()' name='batch2' size='5' autofocus>
                    <option v-for='data in batches2' :value='JSON.stringify([{ id: data.id, text: data.batch }])'>{{ data.batch }}</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Select Record</label>
            <select class='form-control' v-model='record' @change='getRecordMonths()' name='record' required='required'>
                <option v-for='data in records' :value='data.id'>{{ data.semester }}</option>
            </select>
        </div>

        <div class="form-group">
            <label>Select Record</label>
            <select class='form-control' v-model='record_month' name='record_month' required='required'>
                <option v-for='data in record_months' :value='data.id'>{{ data.month }}</option>
            </select>
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return {
                batch1: 0,
                batches1: [],
                batch2: 0,
                batches2: [],
                record: 0,
                records: [],
                record_month: 0,
                record_months: [],
            }
        },
        methods:{
            getBatches1: function(){
                axios.get('/getBatches1')
                    .then(function (response) {
                        this.batches1 = response.data;
                    }.bind(this));

            },
            getBatches2: function(){
                axios.get('/getBatches2')
                    .then(function (response) {
                        this.batches2 = response.data;
                    }.bind(this));

            },
            getRecords1: function () {
                this.batch2 = { val: '' };
                this.record = { val: '' };
                this.record_month = { val: '' };

                var jsonData = JSON.parse(this.batch1);
                var batchData = jsonData[0];

                axios.get('/getRecords',{
                    params: {
                        batch: batchData.text
                    }
                }).then(function(response){
                    this.records = response.data;
                }.bind(this));
            },
            getRecords2: function () {
                this.batch1 = { val: '' };
                this.record = { val: '' };
                this.record_month = { val: '' };

                var jsonData = JSON.parse(this.batch2);
                var batchData = jsonData[0];

                axios.get('/getRecords',{
                    params: {
                        batch: batchData.text
                    }
                }).then(function(response){
                    this.records = response.data;
                }.bind(this));
            },
            getRecordMonths: function () {
                this.record_month = { val: '' };
                axios.get('/getRecordMonths',{
                    params: {
                        record: this.record
                    }
                }).then(function(response){
                    this.record_months = response.data;
                }.bind(this));
            },
        },
        created: function(){
            this.getBatches1()
            this.getBatches2()
        }
    }
</script>
