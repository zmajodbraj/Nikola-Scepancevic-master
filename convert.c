#include <stdio.h>

int main(){
FILE *so,*de;

int c; 
so=fopen("RADNI4.txt", "r");

de=fopen("RADNI5.txt", "w");

while ((c=fgetc(so))!=EOF){
switch(c){
case 131 : fputs("&#226;",de);break;
case 182 : fputs("&#194;",de);break;
case 130 : fputs("&#233;",de);break;
case 144 : fputs("&#201;",de);break;
case 129 : fputs("&#252;",de);break;
case 154 : fputs("&#220;",de);break;
case 148 : fputs("&#246;",de);break;
case 153 : fputs("&#214;",de);break;
case 132 : fputs("&#228;",de);break;
case 142 : fputs("&#196;",de);break; 
case 135 : fputs("&#231;",de);break;
case 128 : fputs("&#199;",de);break;
case 137 : fputs("&#235;",de);break;
case 211 : fputs("&#203;",de);break;
case 159 : fputs("&#269;",de);break;
case 172 : fputs("&#268;",de);break;
case 134 : fputs("&#263;",de);break;
case 143 : fputs("&#262;",de);break;
case 166 : fputs("&#381;",de);break;
case 167 : fputs("&#382;",de);break;
case 208 : fputs("&#273;",de);break;
case 209 : fputs("&#272;",de);break;
case 230 : fputs("&#352;",de);break;
case 231 : fputs("&#353;",de);break;
default : fputc(c, de); 
}
}
fclose(so); fclose(de);

return 0;
}
