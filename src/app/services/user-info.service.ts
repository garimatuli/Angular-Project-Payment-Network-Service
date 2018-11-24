import { Injectable } from '@angular/core';
import {UserInfo} from "../models/user-info.model";
import {Observable, of} from 'rxjs';
import {HttpResponse} from "@angular/common/http";

import { HttpClient } from "@angular/common/http";


//let users: any[] = [] || JSON.parse(localStorage.getItem('userList'));

@Injectable({
  providedIn: 'root'
})
export class UserInfoService {

  constructor(private http: HttpClient) { }

  saveUserInfo(newUser:UserInfo) {
  /*users.push(newUser);
  // console.log('List of Users' + users);
  localStorage.setItem('userList',JSON.stringify(users));
   //  console.log('In Service'+localStorage.getItem("userList"));*/
  //return of(new HttpResponse({status: 200}));

    return <Observable<UserInfo>> this.http.post("http://localhost:80/dbms", newUser);
}

}
