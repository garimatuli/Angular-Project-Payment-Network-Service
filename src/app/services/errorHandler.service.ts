import { Injectable } from '@angular/core';
import {Observable, throwError } from 'rxjs';
import { catchError } from "rxjs/operators";


import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent } from "@angular/common/http";
import { AlertService } from "./alert.service";

// This will intercept the HTTP Response and in case of Error/Exception or 400, will extract
// status_message and throw it

@Injectable({
  providedIn: 'root'
})

export class ErrorHandlerService implements HttpInterceptor {

  constructor( private x: AlertService) { }

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(req)
      .pipe(catchError(errorResponse => {

        let errMsg: string;
        if(errorResponse.status == 400){
          errMsg = errorResponse["error"]["status_message"] ? errorResponse["error"]["status_message"] : errorResponse.toString();
          this.x.error(errMsg);
          return throwError(errMsg);

        }

      }));

  }

}
