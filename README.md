<p align="center"><img src="https://lh3.googleusercontent.com/fife/ABSRlIoLeNUrQzl8vQuDnmz4lzsxHN5xQGcMv89LC8l_aoGw14NddwfECbRK4FH5CVIuwj82QwKpIORKwxFoLH-jqvLZZepQW1UrXIS4pI0KXfmvngNdU3LN8ut1GLkm-mRsIWc4Za0RQYCWjZBhXlrxio13oqM54ar1cWDN4DEEzShUfoJQx5TnhKbUCZOoSHn8aQB8eV3AZuOIo92zuksB9oSfgoCotZO-tcFsMi9mqgVwSkrvioiR6n9npVwfvG99Sz_f7-90SEvcnlvtSSTrhpuFQgIAv6x0cKg8INd6yZ2_N-_wYmVqcTi5oeRq7pYNgj15fBRuWithvMpAzlYLLtM0jdrpea9Xme_uh6t5FgFJ2bjpmnfmwr-D0llpTj2MlS_2bjL42sS_nv0vTL9ZBNl4zbgvxaDnWj5t_9eFODP1H3qmhc5Qm_9lAw8s3-iTLQo4G5oSqSINq7-1A4BGeT-9CvZcrpeDzboRmBz5DBferSzyJffErtP-8Bot6HVghlQ36Nm4kjre9qIsuM0T5_69Stl340DgvrhwkPrp0wwC5YOjNqKRQkVNjFBlGlIwBfXPQEqYh6nzyFnRFy7OhfvxhqzEOKkbMDZWAhvfnWFDtl3vwMy1tl9dNLYm8BCWAn3TGRFWLF-pnylhCOOChzYh_fjZoQJLeY8ByzmKP6DOXLSyVG2ZCsndF0xHvIJdS4dggQMIdH0tWZWXblyPzOMvZlcRLe2h8iI=w2880-h1464-ft" width="800"></p>

## How To Start

Do the following steps inside the root folder to run this app

1. `docker-compose up -d --build`
2. `docker-compose run --rm composer install`
3. `docker-compose run --rm artisan migrate --seed`
4. `docker-compose run --rm npm install`
5. `docker-compose run --rm npm run dev`
6. Access the app on http://localhost:7777
