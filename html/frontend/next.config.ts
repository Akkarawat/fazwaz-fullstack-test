import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  async redirects() {
    return [
      {
        source: "/",
        destination: "/properties",
        permanent: true,
      },
    ];
  },
};

export default nextConfig;

module.exports = nextConfig;
