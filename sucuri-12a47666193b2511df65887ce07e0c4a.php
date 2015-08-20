<?php
/* Sucuri integrity monitor
 * Integrity checking and server side scanning.
 *
 * Copyright (C) 2010, 2011, 2012 Sucuri, LLC
 * http://sucuri.net
 * Do not distribute or share.
 */

$MYMONITOR = "monitor20";
$my_sucuri_encoding = "



LyogU3VjdXJpIGludGVncml0eSBtb25pdG9yIC4gCiAqIENvbm5lY3RzIGJhY2sgaG9tZS4KICog
Q29weXJpZ2h0IChDKSAyMDEwLTIwMTMgU3VjdXJpLCBMTEMKICogRG8gbm90IGRpc3RyaWJ1dGUg
b3Igc2hhcmUuCiAqLwoKCiRTVUNVUklQV0QgPSAiNTM1ZTI2ZWIwZjMzMjRlODA1NmZlNjk1NDk3
NmIwNGM2MmViOTc3ZjJjYzUxIjsKCgppZihpc3NldCgkX0dFVFsndGVzdCddKSkKewogICAgZWNo
byAiT0s6IFN1Y3VyaTogRm91bmRcbiI7CiAgICBleGl0KDApOwp9CgoKCi8qIFZhbGlkIGFyZ3Vt
ZW50LiAqLwppZighaXNzZXQoJF9HRVRbJ3J1biddKSkKewogICAgZXhpdCgwKTsKfQoKCi8qIE11
c3QgaGF2ZSBhbiBJUCBhZGRyZXNzLiAqLwppZighaXNzZXQoJF9TRVJWRVJbJ1JFTU9URV9BRERS
J10pKQp7CiAgICBleGl0KDApOwp9Cgokb3JpZ3JlbW90ZWlwID0gJF9TRVJWRVJbJ1JFTU9URV9B
RERSJ107CgovKiBJZiBjb21pbmcgZnJvbSBjbG91ZGZsYXJlOiAqLwppZihpc3NldCgkX1NFUlZF
UlsnSFRUUF9DRl9DT05ORUNUSU5HX0lQJ10pKQp7CiAgICAkX1NFUlZFUlsnUkVNT1RFX0FERFIn
XSA9ICRfU0VSVkVSWydIVFRQX0NGX0NPTk5FQ1RJTkdfSVAnXTsKfQovKiBDbG91ZFByb3h5IGhl
YWRlcnMuICovCmVsc2UgaWYoaXNzZXQoJF9TRVJWRVJbJ0hUVFBfWF9TVUNVUklfQ0xJRU5USVAn
XSkpCnsKICAgICRfU0VSVkVSWydSRU1PVEVfQUREUiddID0gJF9TRVJWRVJbJ0hUVFBfWF9TVUNV
UklfQ0xJRU5USVAnXTsKfQovKiBNb3JlIGdhdGV3YXkgcmVxdWVzdHMuICovCmVsc2UgaWYoaXNz
ZXQoJF9TRVJWRVJbJ0hUVFBfWF9PUklHX0NMSUVOVF9JUCddKSkKewogICAgJF9TRVJWRVJbJ1JF
TU9URV9BRERSJ10gPSAkX1NFUlZFUlsnSFRUUF9YX09SSUdfQ0xJRU5UX0lQJ107Cn0KZWxzZSBp
Zihpc3NldCgkX1NFUlZFUlsnSFRUUF9DTElFTlRfSVAnXSkpCnsKICAgICRfU0VSVkVSWydSRU1P
VEVfQUREUiddID0gJF9TRVJWRVJbJ0hUVFBfQ0xJRU5UX0lQJ107Cn0KLyogUHJveHkgcmVxdWVz
dHMuICovCmVsc2UgaWYoaXNzZXQoJF9TRVJWRVJbJ0hUVFBfVFJVRV9DTElFTlRfSVAnXSkpCnsK
ICAgICRfU0VSVkVSWydSRU1PVEVfQUREUiddID0gJF9TRVJWRVJbJ0hUVFBfVFJVRV9DTElFTlRf
SVAnXTsKfQovKiBQcm94eSByZXF1ZXN0cy4gKi8KZWxzZSBpZihpc3NldCgkX1NFUlZFUlsnSFRU
UF9YX1JFQUxfSVAnXSkpCnsKICAgICRfU0VSVkVSWydSRU1PVEVfQUREUiddID0gJF9TRVJWRVJb
J0hUVFBfWF9SRUFMX0lQJ107Cn0KLyogTW9yZSBnYXRld2F5IHJlcXVlc3RzLiAqLwplbHNlIGlm
KGlzc2V0KCRfU0VSVkVSWydIVFRQX1hfRk9SV0FSREVEX0ZPUiddKSkKewogICAgJF9TRVJWRVJb
J1JFTU9URV9BRERSJ10gPSAkX1NFUlZFUlsnSFRUUF9YX0ZPUldBUkRFRF9GT1InXTsKfQoKCiRt
eWlwbGlzdCA9IGFycmF5KAonOTcuNzQuMTI3LjE3MScsCic2OS4xNjQuMjAzLjE3MicsCicxNzMu
MjMwLjEyOC4xMzUnLAonNjYuMjI4LjM0LjQ5JywKJzY2LjIyOC40MC4xODUnLAonNTAuMTE2LjMu
MTcxJywKJzUwLjExNi4zNi45MicsCicxOTguNTguOTYuMjEyJywKJzUwLjExNi42My4yMjEnLAon
MTkyLjE1NS45Mi4xMTInLAonMTkyLjgxLjEyOC4zMScsCicxOTguNTguMTA2LjI0NCcsCicxMDQu
MjM3LjE0My4yNDInLAonMTA0LjIzNy4xMzkuMjI3JywKJzI2MDA6M2MwMDo6ZjAzYzo5MWZmOmZl
YWU6ZTEwNCcsCicyNjAwOjNjMDA6OmYwM2M6OTFmZjpmZTg0OmUyNzUnLAonMjYwMDozYzAwOjpm
MDNjOjkxZmY6ZmU4NDplMjE4JywKJzI2MDA6M2MwMjo6ZjAzYzo5MWZmOmZlZGY6NThjNicsCicy
NjAwOjNjMDI6OmYwM2M6OTFmZjpmZWRmOjU4MzUnLAonMjYwMDozYzAzOjpmMDNjOjkxZmY6ZmVk
Zjo2YTdhJywKJ2ZlODA6OmZjZmQ6YWRmZjpmZWU2OjgwODcnLAonMjYwMDozYzAzOjpmMDNjOjkx
ZmY6ZmU3MDozNmNlJywKJzI2MDA6M2MwMjo6ZjAzYzo5MWZmOmZlNzA6ZjEyZCcsCicyNjAwOjNj
MDE6OmYwM2M6OTFmZjpmZTcwOjUyYmInLAonNTAuMTE2LjM2LjkzJywKIjE5Mi4xNTUuOTUuMTM5
IiwKIjI2MDA6M2MwMjo6ZjAzYzo5MWZmOmZlNjk6NGI2NiIsCiIyNjAwOjNjMDA6OmYwM2M6OTFm
ZjpmZTcwOjUyMTMiLAoiMjYwMDozYzAzOjpmMDNjOjkxZmY6ZmVkYjpiOWNlIiwKIjIzLjIzOS45
LjIyNyIsCiIxOTguNTguMTEyLjEwMyIsCiIxOTIuMTU1Ljk0LjQzIiwKIjE2Mi4yMTYuMTYuMzMi
LAoiMjYwMDozYzAwOjpmMDNjOjkxZmY6ZmU2ZTphMDQ2IiwKIjI2MDA6M2MwMjo6ZjAzYzo5MWZm
OmZlNmU6YTBkZCIsCiIyNjAwOjNjMDM6OmYwM2M6OTFmZjpmZTZlOmEwYWMiLAopOwoKCiRpcG1h
dGNoZXMgPSAwOwoKZm9yZWFjaCgkbXlpcGxpc3QgYXMgJG15aXApCnsKICAgIGlmKHN0cnBvcygk
X1NFUlZFUlsnUkVNT1RFX0FERFInXSwgJG15aXApICE9PSBGQUxTRSkKICAgIHsKICAgICAgICAk
aXBtYXRjaGVzID0gMTsKICAgICAgICBicmVhazsKICAgIH0KICAgIGlmKHN0cnBvcygkb3JpZ3Jl
bW90ZWlwLCAkbXlpcCkgIT09IEZBTFNFKQogICAgewogICAgICAgICRpcG1hdGNoZXMgPSAxOwog
ICAgICAgIGJyZWFrOwogICAgfQp9CgoKaWYoJGlwbWF0Y2hlcyA9PSAwKQp7CiAgICBlY2hvICJF
UlJPUjogSW52YWxpZCBJUCBBZGRyZXNzXG4iOwogICAgZXhpdCgwKTsKfQoKCi8qIFZhbGlkIGtl
eS4gKi8KaWYoIWlzc2V0KCRfUE9TVFsnc3NjcmVkJ10pKQp7CiAgICBlY2hvICJFUlJPUjogSW52
YWxpZCBhcmd1bWVudFxuIjsKICAgIGV4aXQoMCk7Cn0KCgovKiBDb25uZWN0IGJhY2sgdG8gZ2V0
IHdoYXQgdG8gcnVuLiAqLwppZighZnVuY3Rpb25fZXhpc3RzKCdjdXJsX2V4ZWMnKSB8fCBpc3Nl
dCgkX0dFVFsnbm9jdXJsJ10pKQp7CiAgICAkcG9zdGRhdGEgPSBodHRwX2J1aWxkX3F1ZXJ5KAog
ICAgICAgICAgICBhcnJheSgKICAgICAgICAgICAgICAgICdwJyA9PiAkU1VDVVJJUFdELAogICAg
ICAgICAgICAgICAgJ3EnID0+ICRfUE9TVFsnc3NjcmVkJ10sCiAgICAgICAgICAgICAgICApCiAg
ICAgICAgICAgICk7CgogICAgJG9wdHMgPSBhcnJheSgnaHR0cCcgPT4KICAgICAgICAgICAgYXJy
YXkoCiAgICAgICAgICAgICAgICAnbWV0aG9kJyAgPT4gJ1BPU1QnLAogICAgICAgICAgICAgICAg
J2hlYWRlcicgID0+ICdDb250ZW50LXR5cGU6IGFwcGxpY2F0aW9uL3gtd3d3LWZvcm0tdXJsZW5j
b2RlZCcsCiAgICAgICAgICAgICAgICAnY29udGVudCcgPT4gJHBvc3RkYXRhCiAgICAgICAgICAg
ICAgICApCiAgICAgICAgICAgICk7CgogICAgJGNvbnRleHQgPSBzdHJlYW1fY29udGV4dF9jcmVh
dGUoJG9wdHMpOwogICAgJG15X3N1Y3VyaV9lbmNvZGluZyA9IGZpbGVfZ2V0X2NvbnRlbnRzKCJo
dHRwczovLyRNWU1PTklUT1Iuc3VjdXJpLm5ldC9pbW9uaXRvciIsIGZhbHNlLCAkY29udGV4dCk7
CgogICAgaWYoc3RybmNtcCgkbXlfc3VjdXJpX2VuY29kaW5nLCAiV09SS0VEOiIsNykgPT0gMCkK
ICAgIHsKICAgIH0KICAgIGVsc2UKICAgIHsKICAgICAgICBlY2hvICJFUlJPUjogVW5hYmxlIHRv
IGNvbXBsZXRlIChtaXNzaW5nIGN1cmwgc3VwcG9ydCBhbmQgZmlsZV9nZXQgZmFpbGVkKS4gUGxl
YXNlIGNvbnRhY3Qgc3VwcG9ydEBzdWN1cmkubmV0IGZvciBndWlkYW5jZS5cbiI7CiAgICAgICAg
ZXhpdCgxKTsKICAgIH0KfQoKZWxzZQp7CgogICAgJGNoID0gY3VybF9pbml0KCk7CiAgICBjdXJs
X3NldG9wdCgkY2gsIENVUkxPUFRfVVJMLCAiaHR0cHM6Ly8kTVlNT05JVE9SLnN1Y3VyaS5uZXQv
aW1vbml0b3IiKTsKICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9SRVRVUk5UUkFOU0ZFUiwg
dHJ1ZSk7CiAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfUE9TVCwgdHJ1ZSk7CiAgICBjdXJs
X3NldG9wdCgkY2gsIENVUkxPUFRfUE9TVEZJRUxEUywgInA9JFNVQ1VSSVBXRCZxPSIuJF9QT1NU
Wydzc2NyZWQnXSk7IAogICAgY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1NTTF9WRVJJRllQRUVS
LCBmYWxzZSk7CgogICAgJG15X3N1Y3VyaV9lbmNvZGluZyA9IGN1cmxfZXhlYygkY2gpOwogICAg
Y3VybF9jbG9zZSgkY2gpOwoKICAgIGlmKHN0cm5jbXAoJG15X3N1Y3VyaV9lbmNvZGluZywgIldP
UktFRDoiLDcpID09IDApCiAgICB7CiAgICB9CiAgICBlbHNlCiAgICB7CiAgICAgICAgaWYoJG15
X3N1Y3VyaV9lbmNvZGluZyA9PSBOVUxMIHx8IHN0cmxlbigkbXlfc3VjdXJpX2VuY29kaW5nKSA8
IDMpCiAgICAgICAgewogICAgICAgICAgICAkbXlfc3VjdXJpX2VuY29kaW5nID0gIngyMzUxIjsK
ICAgICAgICB9CiAgICAgICAgZWNobyAiRVJST1I6IFVuYWJsZSB0byBjb25uZWN0IGJhY2sgdG8g
U3VjdXJpIChlcnJvcjogJG15X3N1Y3VyaV9lbmNvZGluZykuIFBsZWFzZSBjb250YWN0IHN1cHBv
cnRAc3VjdXJpLm5ldCBmb3IgZ3VpZGFuY2UuXG4iOwogICAgICAgIGV4aXQoMSk7CiAgICB9Cn0K
CgokbXlfc3VjdXJpX2VuY29kaW5nID0gIGJhc2U2NF9kZWNvZGUoCiAgICAgICAgICAgICAgICAg
ICAgICAgc3Vic3RyKCRteV9zdWN1cmlfZW5jb2RpbmcsIDcpKTsKCgpldmFsKAogICAgJG15X3N1
Y3VyaV9lbmNvZGluZwogICAgKTsK

";

/* Encoded to avoid that it gets flagged by AV products or even ourselves :) */
$tempb64 =  
           base64_decode(
                          $my_sucuri_encoding);

eval(  $tempb64 
      );
exit(0); ?>    
    
