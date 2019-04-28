<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016092600603276",

		//商户私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAmhM4jjGyqAeWkJLiaOK3tYEMZqApIhzi2iv6/DeDJxw1fQuVYrnJhJnNfnP0/6vlEm6GPbEwFHv0NAWIdOyTTpB9twVvwYw0/j0fK1KW8TzOrus4BdlWQkOjhKZGmJqrIcr4VBsyzO/MxSZ31ORr39En2q/ZuseZwmWeg7yfAred62gBr36S5yiumgEoljCoUApfiLrkmJJr7/VkagHDXa+YxgWq49tXYCoGZ7AAUYds4H17BfDpHKaONSw7cRyghz/dzJEQRf8TSVQIrvfV0t1co8tDBwrgFzV27RmQn1gYtmkIv4oqE0AcFPj+5jql/IbePoOR5CnxwVUWxUtU0wIDAQABAoIBAH3Tbp9pZL6mm8Zrvizr4h1/SzJQX+c08eo8epcZeqko92GsYQ4kLbd1p4U6i3100vlve3/MQTipVfBaCGt8fHxvscsSzIaiyvBJ2DeYFh7iiuP8wl68dB5fgJ2m8QZVYaaSTKTbJWyJ9Y+X78rT1GkPNV35uHU55o8EUCTDmJQtPYYjGfDIW8GsS1fn2859rjBhFgub+NRhNYGCvKYx2PwER+cC2LBaftibNDMGZGu+N9vN5oRtwbMEuQD+/8vO1PNF3xjnCi2aubwd+IYYal93xiW4VMkH+ZDfD4j8geKfZWNj49yNCmLr5SPW909aRD8+foSygEm8knTbAIbYn0ECgYEAyYOtUaAXArTcP4kA6MLgdr1Vrp/Q4ypMvEqMHhP/ffqjuXiahhFguk2k65TbZV8pPd5RTXQm+hYMaPPS0JtS/OgIy4UmWrg/UKfoh7VXMKMHSCTYWT5ABQNvYzfvTBUHWpwp2MO64jpzGs0Faj1g1xf+4cGKOT3X27uYrPDd+qECgYEAw7vqMZzk3/v/8jSidloWFtgs3bv+yU7ihttK30X6ZG4pQ+aP/XI4uXXAVymCHNLQqAXGg9ZPqTKHW20O0LLKfeCgNV6P2trEozJBdiLZYsEE4p1ZMbAgcp5LzYnR4BkQHfypXiiCRZ0ChNCQJcAuK7yBwn3IQvAQPXA+0x4drvMCgYAn3jteGNQ0nt+sWkipxFRwaYkYIVpMd0PzRLRwBvjXTc0ylp/Lwohmk5H7Ydn+NlOMf/2J218Sv2X5JbQhvXkvvCBxU4iBDk7IgE/K+Z+kaby5E0ESdvRniYRyFtDrNoXb8WV+E0tYEsRPGxzlJfuQ0piExau5I3kfagAMxyLDwQKBgGjzJUuc2IvQzxfLaSEUhKuTFdt+pcrC5Wtxwd+d4fhfqPijc6ltyUSIAq25r+5Mi1zMW/jsvKH4WeOHwl3cv/5mpwB2x6ONkcn/dGInpW/yFvB7dgvSaFOM1RBMSaBjT+UESLwX9GHnIiacve2/8gG5fcoPL4XUuqB2wvjoOPpJAoGBAIH2Bk4C5+ERd8+usou0+bQO6pilLwJHRwQFeK2Bq5IIEmycM8XOm/Y1Uliii76MMq4SBjVASGv7CADWG0PMrfyy6mnHE/w1HoSGHeprIj/KY7/GenVpv+8VB4kZ7BLlWuY+T8fsuWyjuzKDd1+XQFNZLEH/2pC7iUCw+az4su8t",
		
		//异步通知地址
		'notify_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://www.larvel.com/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAv0ZbgNTkJEyJZ3mLSJHyr7i80VjYRpAJys3SdN83nKfWsqUgbB7S8n/5mXhq0itvTFZ9+nIB/UBIPEeJgMhu1P/muhn7EbTefxMhQSUkC+8g9FTmzOOWT3WHtQPJ6LlWwtFhTsw7ce58LYtFdN45DECRb9GigxAnivW9HIPp1V1Xm3xOuSrTebDWTtqpm89vnQYHsF3i74uAc9jFb6rhP3HViHyd+fVERZ2Wq9j6ikSK1S5g8WaIlxfdQtgBvDVOqMCsiZc3EEexNSqKFIbEWpWWEzHi5pVAs+BDwOkI83sX9wfCqH85yF6MgAI5FiSrU1WHdAvK1R8cY93qox998QIDAQAB ",
);