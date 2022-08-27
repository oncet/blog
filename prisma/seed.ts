import { PrismaClient } from "@prisma/client";
const prisma = new PrismaClient();

async function main() {
  const post = await prisma.post.upsert({
    where: { slug: "awesome-post" },
    update: {},
    create: {
      slug: "awesome-post",
      title: "Awesome post, man",
      image:
        "https://pnhaelxzpnxiuweilmhz.supabase.co/storage/v1/object/public/blog/remix.jpg",
      body: "Amazing post content. Balizingly fast.",
      category: {
        create: {
          name: "Guides",
          slug: "guides",
        },
      },
      tags: {
        create: [
          {
            name: "React",
            slug: "React",
          },
          {
            name: "Remix",
            slug: "remix",
          },
        ],
      },
      publishedAt: new Date(),
    },
  });
  console.log({ post });
}

main()
  .then(async () => {
    await prisma.$disconnect();
  })
  .catch(async (e) => {
    console.error(e);
    await prisma.$disconnect();
    process.exit(1);
  });
