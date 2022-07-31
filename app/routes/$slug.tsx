import type { LoaderFunction } from "@remix-run/node";
import { json } from "@remix-run/node";
import { useLoaderData } from "@remix-run/react";

type LoaderData = {
  slug: string;
};

export const loader: LoaderFunction = async ({ params }) => {
  return json({ slug: params.slug });
};

export default function Slug() {
  const { slug } = useLoaderData<LoaderData>();

  return <h1>{slug}</h1>;
}
