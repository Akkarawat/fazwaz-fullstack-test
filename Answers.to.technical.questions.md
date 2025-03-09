## How long did you spend on the coding test? What additional features would you consider implementing if you had more time?

About 10 hours in total.

If I had more time, I would have liked to:

- Using location matching algorithms.
- Cleaning up some of the boilerplate files leftover from installing Laravel and NextJs.
- Implement authentication to secure the APIs.
- Polish the frontend a bit more.

## Describe a security best practice you would implement in this application to protect the API.

At minimum, I would set up CORS and API token authentication.

## Explain how you would approach optimizing the performance of the API for handling large amounts of property data.

I would do the following:

- Implement caching.
- Deploy the backend behind Nginx to gain benefits such as high concerrency and load-balancing.

## How would you track down a performance issue in production? Have you ever had to do this? If so, please describe the experience.

We will need systems/tools to collect various application data across our system to be able to accurately narrow down and identify any bottlenecks in our system.

The systems/tools needed for data collection will partly depend on where we deploy our application on, but most major cloud services (AWS, Azure, etc) have built-in monitoring tools.

The examples of such application data include:

- Slow database queries.
- CPU/memory usage for databases and backend services.
- API response time.
- Application logs.
- Application traces
