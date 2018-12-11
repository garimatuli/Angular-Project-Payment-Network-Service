import { Injectable } from '@angular/core';
import { UserInfo } from "../models/user-info.model";
import { Observable, of } from 'rxjs';
import { HttpHeaders, HttpClient } from "@angular/common/http";


const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'application/json;',
    //  'Content-Type':  'application/x-www-form-urlencoded; charset=UTF-8'
     'Cache-Control': 'no-cache',
     'Access-Control-Allow-Origin': '*',
     'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
     'Access-Control-Max-Age': '1728000'
  })
};

@Injectable({
  providedIn: 'root'
})

export class UserInfoService {

  loggedInSsn  : number;
  loggedInIdentifier: string;

  constructor(private http: HttpClient) { }

  saveUserInfo(newUser:UserInfo) {
    return <Observable<UserInfo>>this.http.post("http://localhost/dbms/register", newUser, httpOptions);
  }

  loginService(loginUser:UserInfo){
    return <Observable<UserInfo>> this.http.get("http://localhost/dbms/login?identifier="
      +loginUser.identifier+"&password="+loginUser.password);
  }

  setSSN(ssn)
  {
    this.loggedInSsn = ssn;
  }

  getSSN(){
  return this.loggedInSsn;
  }

  // For using in Send/Request Transaction Table

  setIdentifier(identifierFromLogin)
  {
    this.loggedInIdentifier = identifierFromLogin;
  }

  getIdentifier(){
    return this.loggedInIdentifier;
  }
}
