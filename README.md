clone the project
create database with the same name like in .env file
run the server local
run mailtip for mail services
url principal :http://localhost:8000/api/v1
user{
  Register:{
      Method:post
      route: /register
  }
  Login: {
   Method:post,
   route:/login
   }
   Logout:{
     Method:post,
     route:/logout
   }
   Forgot password:{
     Method:post,
     route:/forgot/password
  }
}
Employee{
  Index:{
    Method:get,
    route:/employee
  }
  Create:{
    Method:poste
    route:/employee
  }
  Show:{
    Method:get,
    route:/employee/{employee}
  }
  Update:{
    Method:patch,
    route:/employee/{employee}
  }
  Delete:{
    Method:delete,
    route:/employee/{employee}
  }
}  
Attendance Manager:{
  Arrive{
    Method:post,
    route:/attendance/arrive
    params:{
       action:A,
       employe_id:id,
       "arrive_time"
    }
  }
  Leave{
    Method:post,
    route:/attendance/leave/{employeeAttendance}
    params:{
       action:L,
       "leave_time"
    }
  }
  Rapport{
    Pdf:{
    Method:get,
    route:/attendance/pdf
    }
    Csv:{
    Method:get,
    route:/attendance/csv
    }
  }
}
