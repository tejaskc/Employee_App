<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header" v-if="isUpdate">Update Employee</div>
          <div class="card-header" v-else>Create Employee</div>
          <div class="card-body">
            <form @submit.prevent="submitform" enctype="multipart/form-data">
              <div class="form-group">
                <label for="name">Employee name</label>
                <validation-provider rules="required" v-slot="{ errors }">
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="Enter Name"
                    v-model="name"
                  />
                  <span class="text-danger">{{ errors[0] }}</span>
                </validation-provider>
              </div>
              <div class="form-group">
                <label for="address">Employee address</label>
                <validation-provider rules="required" v-slot="{ errors }">
                  <input
                    type="text"
                    class="form-control"
                    id="address"
                    placeholder="Enter Address"
                    v-model="address"
                  />
                  <span class="text-danger">{{ errors[0] }}</span>
                </validation-provider>
              </div>
              <div class="form-group">
                <label for="email">Email address</label>
                <ValidationProvider
                  name="email"
                  rules="required|email"
                  v-slot="{ errors }"
                >
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="Enter email"
                    v-model="email"
                  />
                  <span class="text-danger">{{ errors[0] }}</span>
                </ValidationProvider>
              </div>
              <div class="form-group">
                <label for="phone">Phone number</label>
                <ValidationProvider
                  rules="required|integer"
                  v-slot="{ errors }"
                >
                  <input
                    type="text"
                    class="form-control"
                    id="phone"
                    placeholder="Enter phone number"
                    v-model="phoneno"
                  />
                  <span class="text-danger">{{ errors[0] }}</span>
                </ValidationProvider>
              </div>
              <div class="form-group">
                <label for="dob">Date of birth</label>
                <input
                  type="date"
                  class="form-control"
                  id="dob"
                  placeholder="Enter date of birth"
                  v-model="dob"
                />
              </div>
              <div class="form-group">
                <label for="image">Image</label>
                <ValidationProvider rules="ext:jpg,png" v-slot="{ errors }">
                  <input
                    type="file"
                    class="form-control"
                    id="image"
                    accept="image/png, image/jpg, image/jpeg"
                    @change="onImageChange"
                  />
                  <span class="text-danger">{{ errors[0] }}</span>
                </ValidationProvider>
              </div>
              <button
                type="submit"
                class="btn btn-primary mt-2"
                v-if="isUpdate"
              >
                Update
              </button>
              <button type="submit" class="btn btn-primary mt-2" v-else>
                Save
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center mt-5">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header">Employee Details</div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Employee Id</th>
                  <th>Employee Name</th>
                  <th>Address</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>DOB</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="employee in employeedata" :key="employee.id">
                  <td>{{ employee.id }}</td>
                  <td>{{ employee.Employee_Name }}</td>
                  <td>{{ employee.Address }}</td>
                  <td>{{ employee.Email }}</td>
                  <td>{{ employee.Phone }}</td>
                  <td>{{ employee.DOB }}</td>
                  <td>{{ employee.Image }}</td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-success"
                      @click="editEmp(employee.id)"
                    >
                      Edit
                    </button>
                    <button
                      type="button"
                      class="btn btn-danger"
                      @click="deleteEmp(employee.id)"
                    >
                      Delete
                    </button>
                  </td>
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
import { ValidationProvider, extend } from "vee-validate";
import { required, email, integer, ext } from "vee-validate/dist/rules";

extend("email", email);
extend("integer", integer);
extend("ext", ext);
extend("required", {
  ...required,
  message: "This field is required",
});
export default {
  components: {
    ValidationProvider,
  },
  data() {
    return {
      emp_id: null,
      name: null,
      address: null,
      email: null,
      phoneno: null,
      dob: null,
      image: null,
      employeedata: [],
      isUpdate: false,
    };
  },
  created() {
    this.getEmployeeData();
  },
  methods: {
    getEmployeeData() {
      axios
        .get("/employee/summary/")
        .then((response) => {
          this.employeedata = response.data;
        })
        .catch((error) => {
          alert(error);
        });
    },
    onImageChange(e) {
      console.log(e.target.files[0]);
      this.image = e.target.files[0];
    },
    submitform() {
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };
      var data = new FormData();
      data.append("Employee_Name", this.name);
      data.append("Address", this.address);
      data.append("Email", this.email);
      data.append("Phone", this.phoneno);
      data.append("DOB", this.dob);
      data.append("Image", this.image);
      if (this.isUpdate) {
        //update
        data.append("id", this.emp_id);
        axios
          .post("/employee/update", data, config)
          .then((response) => {
            if (response.status == 200) {
              alert(response.data);
              this.getEmployeeData();
              this.reset();
            }
          })
          .catch((error) => {
            alert(error);
          });
      } else {
        // save
        axios
          .post("/employee/create", data, config)
          .then((response) => {
            if (response.status == 200) {
              alert(response.data);
              this.getEmployeeData();
              this.reset();
            }
          })
          .catch((error) => {
            alert(error);
          });
      }
    },
    editEmp(id) {
      let index = this.employeedata.findIndex((emp) => emp.id == id);
      if (index > -1) {
        this.name = this.employeedata[index].Employee_Name;
        this.address = this.employeedata[index].Address;
        this.email = this.employeedata[index].Email;
        this.dob = this.employeedata[index].DOB;
        this.phoneno = this.employeedata[index].Phone;
        this.emp_id = id;
        this.isUpdate = true;
      }
    },
    deleteEmp(id) {
      axios
        .get("/employee/delete/" + id)
        .then((response) => {
          if (response.status == 200) {
            alert(response.data);
            this.getEmployeeData();
          }
        })
        .catch((error) => {
          alert(error);
        });
    },
    reset() {
      this.name = null;
      this.address = null;
      this.email = null;
      this.phoneno = null;
      this.dob = null;
      this.image = null;
      this.isUpdate = false;
    },
  },
};
</script>
