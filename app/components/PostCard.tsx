import type { Post } from "@prisma/client";
import { format } from "date-fns";

type PostCardProps = {
  post: Post;
};

const PostCard: React.FC<PostCardProps> = ({ post }) => {
  return (
    <>
      <h2>{post.title}</h2>
      <p className="text-slate-400">
        {format(new Date(post.updatedAt), "dd/MM/yyyy")}
      </p>
      {post.image && <img src={post.image} alt={post.imageAlt || post.title} />}
    </>
  );
};

export default PostCard;
