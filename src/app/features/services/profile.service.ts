import { Injectable } from '@angular/core';
import {ProfileBankModel, ProfileEmailModel, ProfileNameModel, ProfilePhoneModel} from "../models/profile.model";

import {Observable, of} from 'rxjs';
import {HttpResponse, HttpHeaders} from "@angular/common/http";
import { HttpClient } from "@angular/common/http";

import {UserInfoService} from "../../services/user-info.service";

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

@Injectable()

export class ProfileService {

  constructor(private http: HttpClient, private x: UserInfoService) { }

  saveProfileName(updatedProfile:ProfileNameModel) {

    updatedProfile.ssn = this.x.getSSN();

    return <Observable<ProfileNameModel>>this.http.post("http://localhost/dbms/postProfile", updatedProfile, httpOptions);
  }

  getProfileName(){
    let currentSSN = this.x.getSSN();
    return <Observable<ProfileNameModel>> this.http.get("http://localhost/dbms/getProfile?ssn="+currentSSN);
  }

  getProfileEmail(){
    let currentSSN = this.x.getSSN();
    return <Observable<any>> this.http.get("http://localhost/dbms/getEmail?ssn="+currentSSN);
  }

  getProfilePhone(){
    let currentSSN = this.x.getSSN();
    return <Observable<any>> this.http.get("http://localhost/dbms/getPhone?ssn="+currentSSN);
  }

  getProfileBank(){
    let currentSSN = this.x.getSSN();
    return <Observable<any>> this.http.get("http://localhost/dbms/getBank?ssn="+currentSSN);
  }

  addEmail(addedEmail:ProfileEmailModel){
    addedEmail.ssn = this.x.getSSN();
    return <Observable<ProfileEmailModel>>this.http.post("http://localhost/dbms/postEmail", addedEmail, httpOptions);
  }

  deletedEmail(deletedEmail:ProfileEmailModel){
    // deletedEmail already has ssn,id,identifier via the get call
    return <Observable<ProfileEmailModel>>this.http.post("http://localhost/dbms/deleteEmail",deletedEmail,httpOptions);
  }

  addPhone(addedPhone:ProfilePhoneModel){
    addedPhone.ssn = this.x.getSSN();
    return <Observable<ProfilePhoneModel>>this.http.post("http://localhost/dbms/postPhone", addedPhone, httpOptions);
  }

  deletedPhone(deletedPhone:ProfilePhoneModel){
    // deletedPhone already has ssn,id,identifier via the get call
    return <Observable<ProfilePhoneModel>>this.http.post("http://localhost/dbms/deletePhone",deletedPhone,httpOptions);
  }

  addBank(addedBank:ProfileBankModel){
    addedBank.ssn = this.x.getSSN();
    return <Observable<ProfileBankModel>>this.http.post("http://localhost/dbms/postBank", addedBank, httpOptions);
  }

  deletedBank(deletedBank:ProfileBankModel){
    // deletedEmail already has ssn,id,identifier via the get call
    return <Observable<ProfileBankModel>>this.http.post("http://localhost/dbms/deleteBank",deletedBank,httpOptions);
  }
}
